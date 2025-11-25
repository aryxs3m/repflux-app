<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeightRequest extends FormRequest{
    public function rules(): array
    {
        return [
            'tenant_id' => 'required|exists:tenants,id',
            'user_id' => 'nullable|exists:users,id',
            'measured_at' => 'nullable|date',
            'weight' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
