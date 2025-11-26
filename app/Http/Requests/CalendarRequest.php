<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start' => 'date|required',
            'end' => 'date|required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
