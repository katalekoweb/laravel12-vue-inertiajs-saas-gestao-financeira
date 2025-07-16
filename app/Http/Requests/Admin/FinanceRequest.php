<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FinanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
            'amount' => ['required'],
            'type' => ['required'],
            'category_id' => ['nullable'],
            'tenant_id' => ['nullable'],
            "transaction_date" => ['required', 'date'],
            "is_active" => ["nullable"],
        ];
    }
}
