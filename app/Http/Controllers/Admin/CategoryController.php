<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->when(request('query'), function ($query) {
            $query->where(function ($query) {
                $queryString = request('query');
                $query->where('name', 'like', "%$queryString%");
            });
        })->orderByDesc('id')->paginate(10)->withQueryString();

        $query = request('query');

        return Inertia::render("Admin/Categories/Index", compact('categories', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category();
        $category->is_active = true;
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        return Inertia::render("Admin/Categories/Form", compact("category", "tenants"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        if (isset($data['is_active']) && $data['is_active'] == 'true') $data['is_active'] = 1;
        else $data['is_active'] = 0;

        if (!auth()->user()->is_super_admin && isset($data['tenant_id'])) {
            unset($data['tenant_id']);
        }

        $category = Category::query()->create($data);
        return redirect(route('admin.categories.index'))->with('success', __('Category created successfull'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->is_active = (bool) $category->is_active;
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        return Inertia::render("Admin/Categories/Form", compact("category", "tenants"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category->is_active = (bool) $category->is_active;
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        return Inertia::render("Admin/Categories/Form", compact("category", "tenants"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if (isset($data['is_active']) && $data['is_active'] == 'true') $data['is_active'] = 1;
        else $data['is_active'] = 0;

        if (!auth()->user()->is_super_admin && isset($data['tenant_id'])) {
            unset($data['tenant_id']);
        }

        $category->update($data);
        return redirect(route('admin.categories.index'))->with('success', __('Category updated successfull'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect(route('admin.categories.index'))->with('success', __('Category deleted successfull'));
    }
}
