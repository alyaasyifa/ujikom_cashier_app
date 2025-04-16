<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::orderby('id', 'desc')->get();
        return view('user.index', compact('users'));
    }

    public function create(){
        $user = User::all();
        return view('user.create', compact('user'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|min:3|unique:users,email',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data pengguna!');
    }

    public function edit(string $id){
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required|in:admin,kasir'
        ]);

        $user = User::findOrFail($id);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData); 

        return redirect()->back()->with('success', 'Berhasil mengubah data!');
    }

    public function destroy(string $id){
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data!');
    }

}
