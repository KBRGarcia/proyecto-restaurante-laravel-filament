<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'phone_number',
        'address',
        'profile_picture',
        'role',
        'status',
        'registration_date',
        'last_connection',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'registration_date' => 'datetime',
            'last_connection' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Get the validation rules for the User model.
     *
     * @param bool $isUpdate Whether the validation is for an update operation
     * @return array<string, string|array>
     */
    public static function rules(bool $isUpdate = false): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'profile_picture' => ['nullable', 'string', 'max:255'],
        ];

        // Password validation: 8-16 characters, at least one uppercase, one number, and one special character
        if ($isUpdate) {
            // For updates, password is optional but must meet requirements if provided
            $rules['password'] = [
                'nullable',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/',
            ];
        } else {
            // For creation, password is required
            $rules['password'] = [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/',
            ];
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public static function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser una cadena de texto.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no debe exceder los 16 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial (@$!%*?&#).',
            'phone_number.string' => 'El número de teléfono debe ser una cadena de texto.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'profile_picture.string' => 'La foto de perfil debe ser una cadena de texto.',
        ];
    }
}
