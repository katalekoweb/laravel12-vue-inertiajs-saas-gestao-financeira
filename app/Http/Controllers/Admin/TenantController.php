<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TenantRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::query()->when(request('query'), function ($query) {            
            $query->where(function ($query) {
                $queryString = request('query');
                $query->where('name', 'like', "%$queryString%")
                    ->orWhere('email', 'like', "%$queryString%")
                    ->orWhere('phone', 'like', "%$queryString%");
            });
        })->orderByDesc('id')->paginate(10)->withQueryString();

        $stats = [
            "all_tenants" => Tenant::count(),
            "active_tenants" => Tenant::whereIsActive(1)->count()
        ];

        $query = request('query');

        return Inertia::render("Admin/Tenants/Index", compact('tenants', 'stats', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenant = new Tenant();
        $tenant->is_active = 1;

        return Inertia::render("Admin/Tenants/Form", compact("tenant"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if (isset($data['is_active']) && $data['is_active'] == 'true') $data['is_active'] = 1;
        else $data['is_active'] = 0;

        $tenant = Tenant::query()->create($data);
        return redirect(route('admin.tenants.index'))->with('success', __('Tenant created successfull'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        $tenant->is_active = (bool) $tenant->is_active;
        return Inertia::render("Admin/Tenants/Form", compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        $tenant->is_active = (bool) $tenant->is_active;
        return Inertia::render("Admin/Tenants/Form", compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantRequest $request, Tenant $tenant)
    {
        $data = $request->validated();

        if (isset($data['is_active']) && $data['is_active'] == 'true') $data['is_active'] = 1;
        else $data['is_active'] = 0;

        $tenant->update($data);
        return redirect(route('admin.tenants.index'))->with('success', __('Tenant updated successfull'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return back()->with('success', __('Tenant deleted successfull'));
    }

    public function settingsView(Tenant $tenant)
    {
        return Inertia::render("Admin/Tenants/Settings", compact('tenant'));
    }

    public function settingsUpdate(TenantRequest $request, Tenant $tenant)
    {
        $tenant->update($request->validated());
        return back()->with('success', __('Tenant updated successfull'));
    }
}
