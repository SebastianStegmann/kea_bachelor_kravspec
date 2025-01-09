<?php

namespace App\Http\Controllers;

use App\Models\Spec;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return view('auth.choose');
        }
        $user = auth()->user();
        $specs = auth()->user()->specs;

        if ($request->hasHeader("HX-Request") == true) {
            return view("specs.index", compact("specs"));
        }
        return view("dashboard", [
            "content" => view("specs.index", compact("specs"))->render(),
        ]);
    }

    public function view(Request $request, $id)
    {
        $spec = auth()->user()->specs->find($id);
        // handle if not exist
        $users = $spec->users()->get();

        if ($request->hasHeader("HX-Request") == true) {
            return view("specs.view", compact("spec", "users"));
        }

        return view("dashboard", [
            "content" => view("specs.view", compact("spec", "users"))->render(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "id" => "required",
            "name" => "required",
            "status" => "",
        ]);

        $spec = auth()
            ->user()
            ->specs->find($validatedData["id"]);
        if ($spec === null) {
            return "something went wrong, reload";
        }

        if (!isset($validatedData["status"]) || $spec["status"] == 1) {
            $spec->update($validatedData);
        }

        if (
            isset($validatedData["status"]) &&
            $validatedData["status"] == "Yes" &&
            $spec["status"] == 0
        ) {
            $validatedData["status"] =
                $validatedData["status"] == "Yes" ? 1 : 0;

            DB::transaction(function () use ($spec, $validatedData) {
                $spec->update($validatedData);
                $spec->rows()->update(["accepted_at" => time()]);
            });
        }

        $spec = auth()->user()->specs->find($id);
        $users = $spec->users()->get();
        return view("specs.view", compact("spec", "users"));
    }

    public function create(Request $request)
    {
        if ($request->hasHeader("HX-Request") == true) {
            return view("specs.create");
        }

        return view("dashboard", ["content" => view("specs.create")->render()]);
    }

    public function destroy(Spec $spec)
    {
        if (
            !$spec
                ->users()
                ->wherePivot("role_id", 1)
                ->where("users.id", auth()->id())
                ->exists()
        ) {
            return response()->json(
                ["error" => "You are not authorized to delete this spec."],
                403
            );
        }

        $spec->delete();

        return Response::make("", 200)->header("HX-Redirect", "/");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "spec-name" => "required|string|max:255",
        ]);

        $spec = Spec::create([
            "name" => $validatedData["spec-name"],
        ]);

        $spec->users()->attach(auth()->id(), ["role_id" => 1]);

        $id = $spec->id;

        return Response::make("", 200)->header("HX-Redirect", "/$id");
        // $spec = auth()->user()->specs->find($id);
        // $rows = $spec->getGroupedNonAcceptedRows();
        // return view('spec-rows.suggestions', compact('spec', 'rows'));
    }
}
