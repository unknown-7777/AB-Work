<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::latest();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // Ban / Unban user
    public function toggle(User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403, 'Cannot ban an admin.');
    
        $newStatus = !$user->is_active;
        $user->update(['is_active' => $newStatus]);
    
        $status = $newStatus ? 'activated' : 'banned';
    
        return back()->with('success', "User {$user->name} has been {$status}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403, 'Cannot delete an admin.');

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}