<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordSetQuickCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:record_categories,id',
            'type_id' => 'nullable|exists:record_types,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
