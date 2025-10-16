<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users, email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'must_change_password' => true,
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('admin.users.create')->with('status', 'Kasutaja loodud');
    }
    public function index() {
    $users = User::orderBy('name')->paginate(10);
    return view('admin.users.index', compact('users'));
}


    public function destroy(User $user)  {
            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('status', 'Kasutaja kustutatud.');
        }


}
