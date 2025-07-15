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
            // @TODO filter by name
        })->get();

        return Inertia::render("Admin/Tenants/Index", compact('tenants'));
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
        $tenant = Tenant::query()->create($request->validated());
        return back()->with('success', __('Tenant created successfull'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return Inertia::render("Admin/Tenants/Form", compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return Inertia::render("Admin/Tenants/Form", compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantRequest $request, Tenant $tenant)
    {
        $tenant->update($request->validated());
        return back()->with('success', __('Tenant updated successfull'));
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
