<?php

namespace App\Http\Requests\Admin;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_super_admin == 1 OR $this->user()?->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tenant = request()?->route('tenant');

        return [
            "name" => ["string", "required"],
            "doc" => ["nullable", "string"],
            "email" => ["nullable", "email"],
            "phone" => ["nullable", "string"],
            "address" => ["nullable", "string"],
            "is_active" => ["nullable"],
            "domain" => ["nullable", "string", "unique:tenants,domain,{$tenant?->id}"]
        ];
    }
}
