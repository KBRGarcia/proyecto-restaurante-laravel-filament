<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /**
     * Currency type constants.
     */
    public const CURRENCY_NACIONAL = 'nacional';
    public const CURRENCY_INTERNACIONAL = 'internacional';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_methods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'currency_type',
        'active',
        'configuration',
        'creation_date',
        'update_date',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'configuration' => 'array',
        'creation_date' => 'datetime',
        'update_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active payment methods.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to only include inactive payment methods.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('active', false);
    }

    /**
     * Scope a query to only include national payment methods.
     */
    public function scopeNacional(Builder $query): Builder
    {
        return $query->where('currency_type', self::CURRENCY_NACIONAL);
    }

    /**
     * Scope a query to only include international payment methods.
     */
    public function scopeInternacional(Builder $query): Builder
    {
        return $query->where('currency_type', self::CURRENCY_INTERNACIONAL);
    }

    /**
     * Scope a query to filter by currency type.
     */
    public function scopeByCurrencyType(Builder $query, string $currencyType): Builder
    {
        return $query->where('currency_type', $currencyType);
    }

    /**
     * Check if the payment method is active.
     */
    public function isActive(): bool
    {
        return $this->active === true;
    }

    /**
     * Check if the payment method is inactive.
     */
    public function isInactive(): bool
    {
        return $this->active === false;
    }

    /**
     * Check if the payment method is for national currency.
     */
    public function isNacional(): bool
    {
        return $this->currency_type === self::CURRENCY_NACIONAL;
    }

    /**
     * Check if the payment method is for international currency.
     */
    public function isInternacional(): bool
    {
        return $this->currency_type === self::CURRENCY_INTERNACIONAL;
    }

    /**
     * Get the validation rules for the PaymentMethod model.
     *
     * @param bool $isUpdate Whether the validation is for an update operation
     * @param int|null $id The ID of the payment method being updated (for unique validation)
     * @return array<string, string|array>
     */
    public static function rules(bool $isUpdate = false, ?int $id = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'currency_type' => ['required', 'string', 'in:nacional,internacional'],
            'active' => ['nullable', 'boolean'],
            'configuration' => ['nullable', 'array'],
        ];

        // Code validation: unique for creation and update (ignore current record)
        if ($isUpdate && $id) {
            $rules['code'] = ['required', 'string', 'max:50', 'unique:payment_methods,code,' . $id];
        } else {
            $rules['code'] = ['required', 'string', 'max:50', 'unique:payment_methods,code'];
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
            'code.required' => 'El código es obligatorio.',
            'code.string' => 'El código debe ser una cadena de texto.',
            'code.max' => 'El código no debe exceder los 50 caracteres.',
            'code.unique' => 'Este código ya está registrado.',
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 100 caracteres.',
            'currency_type.required' => 'El tipo de moneda es obligatorio.',
            'currency_type.in' => 'El tipo de moneda seleccionado no es válido.',
            'active.boolean' => 'El campo activo debe ser verdadero o falso.',
            'configuration.array' => 'La configuración debe ser un arreglo.',
        ];
    }
}
