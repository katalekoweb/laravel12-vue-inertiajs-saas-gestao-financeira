<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Models\Tenant;
use Ramsey\Uuid\Uuid;

trait TenantManager
{
    public static function bootTenantManager()
    {
        static::creating(function (Model $model) {
            $user = Auth::user();
            if ($user) {
                if (empty($model->user_id)) {
                    $model->user_id = $user->id;
                }
                if (empty($model->tenant_id)) {
                    $model->tenant_id = $user->tenant_id;
                }
            }
            if (empty($model->uuid)) {
                $model->uuid = (string) Uuid::uuid4();
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->tenant_id) {
                $builder->where('tenant_id', $user->tenant_id);
            }
        });
    }

    // ... (your existing methods: getCurrentTenant, setCurrentTenant, switchTenant)
}
