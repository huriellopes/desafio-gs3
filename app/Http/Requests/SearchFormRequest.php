<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;

class SearchFormRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->role_id === RoleEnum::ADMIN->value;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'search.string' => 'O criterio de busca deve ser uma string',
        ];
    }
}
