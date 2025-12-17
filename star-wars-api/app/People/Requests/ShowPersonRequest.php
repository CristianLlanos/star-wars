<?php

namespace App\People\Requests;

use App\Http\Requests\Traits\JsonFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class ShowPersonRequest extends FormRequest
{
    use JsonFailedValidation;

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'The person id is required.',
            'id.integer' => 'The person id must be an integer.',
            'id.min' => 'The person id must be at least :min.',
        ];
    }
}
