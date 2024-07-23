<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->role_id === RoleEnum::ADMIN->value;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages() : array
    {
        return [
            'name.required' => 'O campo :name é obrigatório.',
            'email.required' => 'O campo :attribute é obrigatório.',
            'email.unique' => 'O email informado ja existe.',
            'email.email' => 'O email informado não é valido.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
            'role_id.integer' => 'O campo perfil deve ser um inteiro.',
            'role_id.required' => 'O campo perfil é obrigatório.',
            'role_id.exists' => 'O campo perfil deve existir.',
        ];
    }
}
