<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class VenezuelaBank extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'venezuela_banks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'active',
        'system_data',
        'creation_date',
    ];

    /**
     * The attributes that should be guarded from mass assignment.
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
        'system_data' => 'array',
        'creation_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active banks.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to only include inactive banks.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('active', false);
    }

    /**
     * Scope a query to search by code or name.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%");
        });
    }

    /**
     * Check if the bank is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active === true;
    }

    /**
     * Get validation rules.
     *
     * @param int|null $id
     * @return array
     */
    public static function rules(?int $id = null): array
    {
        $uniqueCode = $id ? "unique:venezuela_banks,code,{$id}" : 'unique:venezuela_banks,code';

        return [
            'code' => ['required', 'string', 'max:10', $uniqueCode],
            'name' => ['required', 'string', 'max:100'],
            'active' => ['sometimes', 'boolean'],
            'system_data' => ['nullable', 'array'],
            'creation_date' => ['nullable', 'date'],
        ];
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            'code.required' => 'El código del banco es obligatorio.',
            'code.string' => 'El código del banco debe ser una cadena de texto.',
            'code.max' => 'El código del banco no puede exceder los 10 caracteres.',
            'code.unique' => 'El código del banco ya está registrado.',
            'name.required' => 'El nombre del banco es obligatorio.',
            'name.string' => 'El nombre del banco debe ser una cadena de texto.',
            'name.max' => 'El nombre del banco no puede exceder los 100 caracteres.',
            'active.boolean' => 'El estado del banco debe ser verdadero o falso.',
            'system_data.array' => 'Los datos del sistema deben ser un array.',
            'creation_date.date' => 'La fecha de creación debe ser una fecha válida.',
        ];
    }
}
