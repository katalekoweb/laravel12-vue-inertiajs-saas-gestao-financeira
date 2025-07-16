<?php

namespace App\Models;

use App\Traits\TenantManager;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use TenantManager;

    protected $guarded = [];
    const TYPES = [
        'income' => 'Income',
        'expense' => 'Expense',
        'loan' => 'Loan',
        'debt' => 'Debt'
    ];


    // Getter and Setter for is_active
    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (bool) $value,
            set: fn ($value) => $value ? 1 : 0
        );
    }

    // Getter and Setter for transaction_date
    protected function transactionDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date('Y-m-d', strtotime($value)) : null,
            set: fn ($value) => $value //
        );
    }

    // Getter and Setter for amount (format on get, clean on set)
    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => formatCurrency($value),
            set: function ($value) {
                // Remove everything except numbers, comma, and dot
                if (is_string($value)) {
                    $cleaned = preg_replace('/[^\d,\.]/', '', $value);
                    $cleaned = str_replace(['.', ','], ['', '.'], $cleaned);
                    return floatval($cleaned);
                }
                return $value;
            }
        );
    }

    public function category () {
        return $this->belongsTo(Category::class);
    }
}
