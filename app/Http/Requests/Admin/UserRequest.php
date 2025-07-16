<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user = request()?->route('user');

        return [
            "name" => ["string", "required"],
            "email" => ["nullable", "email", "unique:users,email,{$user?->id}"],
            "role" => ["required", "string"],
            "tenant_id" => ["nullable", "numeric", "exists:tenants,id"],
            "is_active" => ["nullable"],
        ];
    }
}
