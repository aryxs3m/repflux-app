<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApiContextRequest extends FormRequest{
    public function rules(): array
    {
        return [
            'tenant_id' => 'required|exists:tenants,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
