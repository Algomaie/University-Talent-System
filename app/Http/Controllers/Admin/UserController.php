<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:admin');
    }

    public function index()
    {
        // Fixed: Use the role column instead of roles relationship for filtering
        $users = User::where('role', '!=', 'admin')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', __('User created successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('An error occurred while creating the user.'));
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', __('User updated successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('An error occurred while updating the user.'));
        }
    }

    public function destroy(User $user)
    {
        // Don't allow deletion of admin users
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                ->with('error', __('Admin users cannot be deleted.'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', __('User deleted successfully!'));
    }

    public function toggleStatus(Request $request, User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        return response()->json([
            'success' => true,
            'message' => __('User status updated successfully!'),
            'is_active' => $user->is_active
        ]);
    }
}