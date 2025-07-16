<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FinanceRequest;
use App\Models\Category;
use App\Models\Finance;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $finances = Finance::query()->when(request('query'), function ($query) {
            $query->where(function ($query) {
                $queryString = request('query');
                $query->where('description', 'like', "%$queryString%");
            });
        })
        ->with(['category'])
        ->orderByDesc('id')->paginate(10)->withQueryString();

        $stats = [
            "all_finances" => Finance::count(),
            "active_finances" => Finance::whereIsActive(1)->count(),
            "incomes" => formatCurrency(Finance::whereIsActive(1)->whereType('income')->sum('amount')),
            "expenses" => formatCurrency(Finance::whereIsActive(1)->whereType('expense')->sum('amount')),
        ];

        $query = request('query');

        return Inertia::render("Admin/Finances/Index", compact('finances', 'query', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $finance = new Finance();
        $finance->is_active = true;
        $finance->transaction_date = date("Y-m-d");
        $finance->type = 'income';

        $categories = Category::select('name', 'id')->orderBy('name')->get();
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        $types = Finance::TYPES;

        return Inertia::render("Admin/Finances/Form", compact("finance", "categories", "tenants", "types"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FinanceRequest $request)
    {
        $data = $request->validated();

        if (isset($data['is_active']) && $data['is_active'] == 'true') $data['is_active'] = 1;
        else $data['is_active'] = 0;

        if (!auth()->user()->is_super_admin && isset($data['tenant_id'])) {
            unset($data['tenant_id']);
        }

        $finance = Finance::query()->create($data);
        return redirect(route('admin.finances.index'))->with('success', __('Record created successfull'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Finance $finance)
    {
        $finance->is_active = true;
        $categories = Category::select('name', 'id')->orderBy('name')->get();
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        $types = Finance::TYPES;
        return Inertia::render("Admin/Finances/Form", compact("finance", "categories", "tenants", "types"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        $finance->is_active = true;
        $categories = Category::select('name', 'id')->orderBy('name')->get();
        $tenants = Tenant::select('name', 'id')->orderBy('name')->get();
        $types = Finance::TYPES;
        return Inertia::render("Admin/Finances/Form", compact("finance", "categories", "tenants", "types"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FinanceRequest $request, Finance $finance)
    {
        $data = $request->validated();

        if (isset($data['is_active']) && $data['is_active'] == 'true') $data['is_active'] = 1;
        else $data['is_active'] = 0;

        if (!auth()->user()->is_super_admin && isset($data['tenant_id'])) {
            unset($data['tenant_id']);
        }

        $finance->update($data);
        return redirect(route('admin.finances.index'))->with('success', __('Record updated successfull'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        $finance->delete();
        return redirect(route('admin.finances.index'))->with('success', __('Record deleted successfull'));
    }
}
