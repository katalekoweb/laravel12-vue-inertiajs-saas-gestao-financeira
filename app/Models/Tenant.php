<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

     // Getter and Setter for is_active
    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (bool) $value,
            set: fn ($value) => $value ? 1 : 0
        );
    }
}
