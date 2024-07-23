<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->role_id === RoleEnum::ADMIN->value;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O campo :attribute é obrigatório.',
            'name.string' => 'O campo :attribute deve ser uma string.',
            'name.max' => 'O campo :attribute deve ter no maúximo :max caracteres.',
            'description.required' => 'O campo :attribute é obrigatório.',
            'description.string' => 'O campo :attribute deve ser uma string.',
            'description.max' => 'O campo :attribute deve ter no maúximo :max caracteres.',
        ];
    }
}
