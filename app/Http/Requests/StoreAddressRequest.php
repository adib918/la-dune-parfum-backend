<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'region' => ['required', 'string'],
            'road' => ['required', 'string'],
            'building' => ['nullable', 'string'],
            'floor' => ['required_with:building', 'numeric', 'nullable'],
            'apartment' => ['numeric', 'required_with:building', 'nullable'],
        ];
    }
}
