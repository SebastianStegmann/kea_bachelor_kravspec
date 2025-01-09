<?php

namespace App\Http\Controllers;

use App\Models\SpecRow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SpecRowController extends Controller
{
    public function index(Request $request, $id, $time = null)
    {
        $spec = Auth::user()->specs->find($id);

        if (!$spec) {
            abort(404);
        }

        if ($time === null) {
            $rows = $spec->getGroupedLatestRows()->map(function ($row) {
                return [
                    "row" => $row,
                    "previousVersion" => null,
                    "changeType" => null,
                ];
            });
        } else {
            $rows = $spec->GetGroupedRowsByTime($time);
        }

        $timeline = match ($spec->status) {
            0 => null,
            default => $spec->fetchTimelineOfAcceptedChanges(),
        };

        if ($request->hasHeader("HX-Request")) {
            return view(
                "spec-rows.index",
                compact("spec", "rows", "timeline", "time")
            );
        }

        return view("dashboard", [
            "content" => view(
                "spec-rows.index",
                compact("spec", "rows", "timeline", "time")
            )->render(),
        ]);
    }

    public function timeline(Request $request, $id)
    {
        $spec = auth()->user()->specs->find($id);
        $timeline = $spec->fetchTimelineOfAcceptedChanges();
        $time = $request->query("time");

        return view("spec-rows.partials.timeline", [
            "spec" => $spec,
            "timeline" => $timeline,
            "time" => $time,
        ]);
    }

    public function table(Request $request, $id, $time = null)
    {
        $spec = Auth::user()->specs->find($id);

        if (!$spec) {
            abort(404);
        }

        if ($time === null) {
            $rows = $spec->getGroupedLatestRows()->map(function ($row) {
                return [
                    "row" => $row,
                    "previousVersion" => null,
                    "changeType" => null,
                ];
            });
        } else {
            $rows = $spec->GetGroupedRowsByTime($time);
        }

        return view("spec-rows.partials.table", [
            "spec" => $spec,
            "rows" => $rows,
            "time" => $time,
        ]);
    }

    public function suggestions(Request $request, $id)
    {
        $spec = Auth::user()->specs->find($id);

        if (!$spec || $spec->status !== 1) {
            abort(404);
        }

        $rows = $spec->getGroupedNonAcceptedRows();

        if ($request->hasHeader("HX-Request") == true) {
            return view("spec-rows.suggestions", compact("spec", "rows"));
        }

        return view("dashboard", [
            "content" => view(
                "spec-rows.suggestions",
                compact("spec", "rows")
            )->render(),
        ]);
    }

    public function update(Request $request, SpecRow $specRow)
    {
        $validatedData = $request->validate([
            "content" => "required",
            "spec_id" => "required",
            "priority" => "required",
        ]);

        $spec = auth()
            ->user()
            ->specs->find($validatedData["spec_id"]);

        // Check if this is a suggestion (accepted_at = 0)
        if ($specRow->accepted_at == 0) {
            // Directly update the suggestion
            $specRow->update([
                "content" => $validatedData["content"],
                "priority" => $validatedData["priority"],
            ]);
        } else {
            // Handle normal edits as before
            if ($spec->status == 1) {
                return "Something went wrong";
            }
            $specRow->update($validatedData);
        }

        // check if request was made from /suggestions page
        if ($request->header('HX-Current-URL') && str_contains($request->header('HX-Current-URL'), '/suggestions')) {
            return Response::make("", 200)->header(
                "HX-Redirect",
                "/$spec->id/suggestions"
            );
        }
        /*return back();*/
        return Response::make("", 200)->header(
            "HX-Redirect",
            "/$spec->id"
        );
    }

    // this should overwrite the edited row if status is 0, and make new row if status is 1
    // or make two forms in the frontend?? and send correct http request?
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "content" => "required",
            "spec_id" => "required",
            "priority" => "required",
            "version" => "",
            "row_identifier" => "",
        ]);

        //is user allowed to edit current spec
        //Find user is related to spec via spec_user_role

        $spec_id = $validatedData["spec_id"];
        $spec = auth()->user()->specs->find($spec_id);

        $validatedData["accepted_at"] = match ($spec["status"]) {
            0 => time(),
            1 => 0,
        };

        SpecRow::create($validatedData);
        return back();
    }

    public function accept(Request $request, SpecRow $specRow)
    {
        $spec = auth()
            ->user()
            ->specs->find($specRow->spec_id);

        if (!$spec || $spec->status !== 1) {
            return "Something went wrong";
        }

        $specRow->update([
            "accepted_at" => time(),
        ]);

        return Response::make("", 200)->header(
            "HX-Redirect",
            "/$spec->id/suggestions"
        );
    }

    public function destroy(SpecRow $specRow)
    {
        $spec = auth()
            ->user()
            ->specs->find($specRow->spec_id);

        if (!$spec) {
            return "Something went wrong";
        }

        // If it's a suggestion (not accepted), permanently delete
        if ($specRow->accepted_at == 0) {
            $specRow->forceDelete();
            return Response::make("", 200)->header(
                "HX-Redirect",
                "/$spec->id/suggestions"
            );
        }

        // Only delete the specific row version, not all versions
        $specRow->delete();

        return Response::make("", 200)->header("HX-Redirect", "/$spec->id");
    }
}
