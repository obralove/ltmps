<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LiveStockCreateRequest extends FormRequest
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
            'owner' => 'required|string',
            'veterinarian' => 'required|string',
            'name' => 'required|string',
            'date_of_birth' => 'required|date',
            'livestock' => 'required|string|exists:livestock_names,name',
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
