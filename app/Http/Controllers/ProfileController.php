<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        if ($request->hasHeader("HX-Request")) {
            return view("profile.edit", [
                "user" => $request->user(),
            ]);
        }

        return view("dashboard", [
            "content" => view("profile.edit", [
                "user" => $request->user(),
            ])->render(),
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty("email")) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if ($request->hasHeader("HX-Request")) {
            return response("")->header("HX-Redirect", "/profile");
        }

        return Redirect::route("profile.edit");
    }

    public function destroy(Request $request)
    {
        try {
            $validated = $request->validate([
                "password" => ["required", "current_password"],
            ]);

            $user = $request->user();
            Auth::logout();
            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->hasHeader("HX-Request")) {
                return response()->header("HX-Redirect", "/");
            }

            return Redirect::to("/");
        } catch (ValidationException $e) {
            if ($request->hasHeader("HX-Request")) {
                return response()->view(
                    "profile.partials.delete-user-form",
                    [
                        "errors" => $e->errors(),
                    ],
                    422
                );
            }
            throw $e;
        }
    }
}
