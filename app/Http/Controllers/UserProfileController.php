<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserProfileController extends Controller
{
    public function show($user_id)
    {
        $user = User::find($user_id);

        return view('pages.user-profile', compact('user'));
    }

    public function update($user_id)
    {
        $data = request()->validate([
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'string', 'max:255',  Rule::unique('users')->ignore($user_id),],
            'title' => ['max:255'],
        ]);

        $user = User::find($user_id);
        $user->update($data);
        return back()->with('succes', 'Profile succesfully updated');
    }


    public function active($user_id)
    {
        $user = User::find($user_id);
        $user->update(['address' => null]);
        return back()->with('succes', 'Profile succesfully updated');
    }


    public function inactive($user_id)
    {
        if ($user_id == 1) {
            throw ValidationException::withMessages(['Cannot make admin inactive']);
        }
        $user = User::find($user_id);
        $user->update(['address' => 'inactive']);
        return back()->with('succes', 'Profile succesfully updated');
    }
}
