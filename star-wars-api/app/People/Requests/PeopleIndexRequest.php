<?php

namespace App\People\Requests;

use App\Http\Requests\Traits\JsonFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class PeopleIndexRequest extends FormRequest
{
    use JsonFailedValidation;

    protected function prepareForValidation(): void
    {
        $this->merge([
            'per_page' => $this->input('per_page', 15),
            'page' => $this->input('page', 1),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:2', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The name filter must be a string.',
            'name.min' => 'The name filter must be at least :min characters.',
            'name.max' => 'The name filter may not be greater than :max characters.',
            'page.integer' => 'The page must be an integer.',
            'page.min' => 'The page must be at least :min.',
            'per_page.integer' => 'The per_page must be an integer.',
            'per_page.min' => 'The per_page must be at least :min.',
            'per_page.max' => 'The per_page may not be greater than :max.',
        ];
    }
}
