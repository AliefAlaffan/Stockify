<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            })
            ->when($request->role, fn ($q) => $q->where('role', $request->role))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        if ($request->ajax()) {
            return view('users._table', compact('users'))->render();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in(['Admin', 'Manajer Gudang', 'Staff Gudang'])],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in(['Admin', 'Manajer Gudang', 'Staff Gudang'])],
        ]);

        // Cegah Admin terakhir di-downgrade ke role lain
        if ($user->role === 'Admin' && $validated['role'] !== 'Admin') {
            $adminCount = User::where('role', 'Admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('users.edit', $user->id)
                    ->with('error', 'Tidak bisa mengubah role Admin terakhir. Sistem harus punya minimal 1 Admin.');
            }
        }

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        // Cegah Admin terakhir dihapus
        if ($user->role === 'Admin') {
            $adminCount = User::where('role', 'Admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('users.index')
                    ->with('error', 'Tidak bisa menghapus Admin terakhir. Sistem harus punya minimal 1 Admin.');
            }
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}