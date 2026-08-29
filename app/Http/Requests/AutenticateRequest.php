<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AutenticateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => ['required', 'email', 'exists:users,email'],
            "password" => ['required', 
                Password::min(8)    # Mínimo 8 caracteres.
                    ->mixedCase()   # Requer letra maíscula e minúscula.
                    ->letters()     # Requer uma letra
                    ->numbers()    # Requer um número 
                    ->symbols()]     # Requer um caractere especial.
        ];
    }
}
