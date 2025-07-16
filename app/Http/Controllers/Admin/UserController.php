<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Tenant;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = TenantUser::query()->when(request('query'), function ($query) {
            $query->where(function ($query) {
                $queryString = request('query');
                $query->where('name', 'like', "%$queryString%")
                    ->orWhere('email', 'like', "%$queryString%");
            });
        })->orderByDesc('id')->paginate(10)->withQueryString();

        $stats = [
            "all_users" => TenantUser::count(),
            "active_users" => TenantUser::whereIsActive(1)->count()
        ];

        $query = request('query');

        return Inertia::render("Admin/Users/Index", compact('users', 'stats', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $user->is_active = true;
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        # dd($tenants);
        return Inertia::render("Admin/Users/Form", compact("user", "tenants"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt(uniqid());

        if (isset($data['is_active']) && $data['is_active'] == 'true') $data['is_active'] = 1;
        else $data['is_active'] = 0;

        if (!auth()->user()->is_super_admin && isset($data['tenant_id'])) {
            unset($data['tenant_id']);
        }

        $user = TenantUser::query()->create($data);
        return redirect(route('admin.users.index'))->with('success', __('User created successfull'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $tenantUser = TenantUser::findOrFail($user->id);

        $user->is_active = (bool) $user->is_active;
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        return Inertia::render("Admin/Users/Form", compact("user", "tenants"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $tenantUser = TenantUser::findOrFail($user->id);

        $user->is_active = (bool) $user->is_active;
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        return Inertia::render("Admin/Users/Form", compact("user", "tenants"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $tenantUser = TenantUser::findOrFail($user->id);

        $data = $request->validated();

        if (!auth()->user()->is_super_admin && isset($data['tenant_id'])) {
            unset($data['tenant_id']);
        }

        if (isset($data['is_active']) && $data['is_active'] == 'true') $data['is_active'] = 1;
        else $data['is_active'] = 0;

        $user->update($data);
        return redirect(route('admin.users.index'))->with('success', __('User updated successfull'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $tenantUser = TenantUser::findOrFail($user->id);

        $user->delete();
        return redirect(route('admin.users.index'))->with('success', __('User deleted successfull'));
    }
}
