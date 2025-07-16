<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    protected $fillable = [
        "uuid",
        "name",
        "email",
        "phone",
        "address",
        "doc",
        "domain",
        "is_active",
        "user_id"
    ];

    public function user (): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
