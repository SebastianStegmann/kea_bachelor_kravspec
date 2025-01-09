<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    // public function update(Request $request): RedirectResponse
    // {
    //     $validated = $request->validateWithBag('updatePassword', [
    //         'current_password' => ['required', 'current_password'],
    //         'password' => ['required', Password::defaults(), 'confirmed'],
    //     ]);

    //     $request->user()->update([
    //         'password' => Hash::make($validated['password']),
    //     ]);

    //     return back()->with('status', 'password-updated');
    // }

    public function update(Request $request)
    {
        $validated = $request->validateWithBag("updatePassword", [
            "current_password" => ["required", "current_password"],
            "password" => ["required", Password::defaults(), "confirmed"],
        ]);

        $request->user()->update([
            "password" => Hash::make($validated["password"]),
        ]);

        if ($request->hasHeader("HX-Request")) {
            $view = view("profile.partials.update-password-form", [
                "status" => "password-updated",
            ])->render();

            return response($view)->header(
                "HX-Trigger",
                json_encode(["showMessage" => "Password updated successfully"])
            );
        }

        return back()->with("status", "password-updated");
    }
}
