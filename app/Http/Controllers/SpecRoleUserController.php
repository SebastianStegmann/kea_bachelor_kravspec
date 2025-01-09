<?php

namespace App\Http\Controllers;

use App\Models\Spec;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecRoleUserController extends Controller
{
    public function store(Request $request, $id)
    {
        $validatedRequest = $request->validate([
            'email' => 'required',
            'role' => 'required',
        ]);

        if (!in_array($validatedRequest['role'], [2, 3])) {
            return 'Something went wrong';
        }

        $spec = auth()->user()->specs->find($id);
        $user = User::where('email', $validatedRequest['email'])->first();

        //check if user already exists
        if ($user) {
            if (!$spec->users()->where('user_id', $user->id)->exists()) {
                $spec->users()->attach($user->id, ['role_id' => $validatedRequest['role']]);
            } else {
                return 'User already added';
            }
        } else {
            return 'User doesnt exist';
        }

        $pivot = $user->specs()->where('spec_id', $id)->first()->pivot;

        return Response::make('', 200)->header('HX-Redirect', "/$id/settings");
    }

    public function destroy(Request $request, $id)
    {
        $validatedRequest = $request->validate([
            'user_id' => 'required',
        ]);

        // check if spec exists
        // Check if deleting user is not deleting themselves
        // Remove option to remove self in ui
        $admin_user_id = auth()->user()->id;
        $spec = Spec::find($id);
        $admin_exists = $spec->users()
            ->wherePivot('user_id', $admin_user_id)
            ->wherePivot('role_id', 1) // $roleId is the role you're checking for
            ->exists();


        $user_exists = $spec->users()
            ->wherePivot('user_id', $validatedRequest['user_id'])
            ->wherePivot('role_id', '!=', 1) // $roleId is the role you're checking for
            ->exists();


        if ($admin_exists && $user_exists) {

            $spec->users()->detach($validatedRequest['user_id']);
            return Response::make('', 200)->header('HX-Redirect', "/$id/settings");
        }

        return 'Something went wrong';
    }
}
