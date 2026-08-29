<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => ['required', 'email', 'unique:users,email'],
            "name" => ['required', 'unique:users,name'],
            "password" => ['required', 'confirmed',
                Password::min(8)    # Mínimo 8 caracteres.
                    ->mixedCase()   # Requer letra maíscula e minúscula.
                    ->letters()     # Requer uma letra
                    ->numbers()    # Requer um número 
                    ->symbols()]     # Requer um caractere especial.
        ];
    }
}
