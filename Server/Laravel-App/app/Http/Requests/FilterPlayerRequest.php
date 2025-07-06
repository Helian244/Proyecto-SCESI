<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterPlayerRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'rating' => 'sometimes|integer|min:0',
            'sort_by' => 'sometimes|in:name,email,rating',
            'sort_dir' => 'sometimes|in:asc,desc',
            'page' => 'sometimes|integer|min:1',
        ];
    }
}
