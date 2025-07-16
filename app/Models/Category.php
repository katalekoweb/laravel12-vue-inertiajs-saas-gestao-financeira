<?php

namespace App\Models;

use App\Traits\TenantManager;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use TenantManager;
    protected $fillable = ['name', 'tenant_id', 'is_active', "user_id", 'uuid'];
}
