<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function ban(User $user)
    {
        if (! $user->banned_at) {
            $user->update(['banned_at' => now()]);
        }
        return redirect()->route('users.index')
                         ->with('success', "Usuário “{$user->name}” banido.");
    }

    public function unban(User $user)
    {
        if ($user->banned_at) {
            $user->update(['banned_at' => null]);
        }
        return redirect()->route('users.index')
                         ->with('success', "Usuário “{$user->name}” desbanido.");
    }

    public function promote(User $user)
    {
        $user->update(['role' => 'moderator']);
        return redirect()->route('users.index')
                         ->with('success', "Usuário “{$user->name}” promovido.");
    }

    public function demote(User $user)
    {
        $user->update(['role' => 'user']);
        return redirect()->route('users.index')
                         ->with('success', "Usuário “{$user->name}” rebaixado.");
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                         ->with('success', "Usuário “{$user->name}” excluído.");
    }
}
