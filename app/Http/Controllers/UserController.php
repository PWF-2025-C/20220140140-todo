<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('todos') // Agar $user->todos bisa diakses di Blade
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('user.index', compact('users'));
    }

    // Membuat user jadi admin
    public function makeadmin(User $user)
    {
        $user->timestamps = false; // Supaya updated_at tidak berubah
        $user->is_admin = true;
        $user->save();

        return back()->with('success', 'Make admin successfully!');
    }

    // Menghapus status admin
    public function removeadmin(User $user)
    {
        // Jangan hapus admin dari user id 1 (superadmin)
        if ($user->id != 1) {
            $user->timestamps = false;
            $user->is_admin = false;
            $user->save();

            return back()->with('success', 'Remove admin successfully!');
        } else {
            return redirect()->route('user.index');
        }
    }

    // Menghapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Delete user successfully!');
    }

    // Form edit user
    public function edit(User $user)
    {
        if (Auth::user()->id === $user->id || Auth::user()->is_admin) {
            return view('user.edit', compact('user'));
        } else {
            return redirect()
                ->route('user.index')
                ->with('danger', 'You are not authorized to edit this user!');
        }
    }

    // Simpan perubahan user
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        // Jika admin, boleh ubah email dan password
        if (Auth::user()->is_admin) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
            $rules['password'] = 'nullable|min:8';
        }

        $validated = $request->validate($rules);

        $user->name = ucfirst($validated['name']);

        // Jika admin, update email dan password
        if (Auth::user()->is_admin) {
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }
        }

        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'User updated successfully!');
    }
}
