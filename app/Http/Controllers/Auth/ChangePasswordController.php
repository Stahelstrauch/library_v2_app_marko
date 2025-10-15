<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    public function edit() { //Parooli muutmise vorm
        return view('auth.passwords.change');
    }

    // Parooli muutmine andmebaasis
    public function update(Request $request) {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->must_change_password = false; //reset lipp, kui FORCE asjad tehtud
        $user->save();

        return back()->with('status', 'Parool uuendatud');
    }
}
