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
        return $this->user()?->is_super_admin == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tenant = new Tenant();

        return [
            "name" => ["string", "required"],
            "doc" => ["nullable", "string"],
            "email" => ["email", "required"],
            "phone" => ["nullable", "string"],
            "address" => ["nullable", "string"],
            "is_active" => ["numeric", "required"],
            "domain" => ["nullable", "string", "unique:tenants,domain,{$tenant->id}"]
        ];
    }
}
