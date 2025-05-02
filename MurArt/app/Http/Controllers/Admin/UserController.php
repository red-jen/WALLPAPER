<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sort results
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        // Make sure we only allow valid fields
        $allowedSortFields = ['name', 'email', 'role', 'status', 'created_at'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }

        $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,designer,customer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,designer,customer',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Update the user status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => ['required', Rule::in(['active', 'pending', 'banned'])],
        ]);

        $oldStatus = $user->status;
        $user->status = $request->status;
        $user->save();

        // Log this activity
        if (class_exists(Activity::class)) {
            Activity::log(
                'user_status_updated',
                "User {$user->name}'s status changed from {$oldStatus} to {$request->status}",
                auth()->user(),
                $user
            );
        }

        return redirect()->back()->with('success', "User status has been updated to {$request->status}.");
    }

    /**
     * Ban a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function ban(User $user)
    {
        // Prevent self-banning
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot ban your own account.');
        }

        $user->status = 'banned';
        $user->save();

        // Log activity
        if (class_exists(Activity::class)) {
            Activity::log(
                'user_banned',
                "User {$user->name} was banned",
                auth()->user(),
                $user
            );
        }

        return redirect()->back()->with('success', 'User has been banned.');
    }

    /**
     * Activate a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function activate(User $user)
    {
        $user->status = 'active';
        $user->save();

        // Log activity
        if (class_exists(Activity::class)) {
            Activity::log(
                'user_activated',
                "User {$user->name} was activated",
                auth()->user(),
                $user
            );
        }

        return redirect()->back()->with('success', 'User has been activated.');
    }

    /**
     * Perform bulk actions on selected users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,ban',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $userIds = $request->user_ids;
        $action = $request->action;
        $count = 0;

        // Make sure admin can't perform actions on their own account
        if (in_array(auth()->id(), $userIds)) {
            return redirect()->back()->with('error', 'You cannot perform bulk actions on your own account.');
        }

        switch ($action) {
            case 'delete':
                $count = User::whereIn('id', $userIds)->delete();
                $message = "{$count} users have been deleted.";
                break;

            case 'activate':
                $count = User::whereIn('id', $userIds)->update(['status' => 'active']);
                $message = "{$count} users have been activated.";
                break;

            case 'ban':
                $count = User::whereIn('id', $userIds)->update(['status' => 'banned']);
                $message = "{$count} users have been banned.";
                break;
        }

        // Log activity
        if (class_exists(Activity::class)) {
            Activity::log(
                'user_bulk_action',
                "Bulk action '{$action}' performed on {$count} users",
                auth()->user()
            );
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Get users as a partial HTML view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUsersPartial(Request $request)
    {
        $search = $request->input('search', '');
        $role = $request->input('role', '');

        $users = User::query();

        if (!empty($search)) {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($role)) {
            $users->where('role', $role);
        }

        $users = $users->latest()->take(10)->get();

        return view('admin.partials.users-list', ['users' => $users])->render();
    }
}
