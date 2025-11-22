<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhysicalPaymentOrders extends Model
{
    /**
     * Status constants.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELED = 'canceled';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'physical_payment_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'limit_date',
        'status',
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
        'limit_date' => 'datetime',
        'creation_date' => 'datetime',
        'update_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the order that owns the physical payment order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scope a query to only include pending physical payment orders.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include confirmed physical payment orders.
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * Scope a query to only include canceled physical payment orders.
     */
    public function scopeCanceled(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_CANCELED);
    }

    /**
     * Scope a query to filter by order.
     */
    public function scopeByOrder(Builder $query, int $orderId): Builder
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * Scope a query to filter by limit date range.
     */
    public function scopeByLimitDateRange(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('limit_date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to filter by expired orders (limit_date has passed).
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('limit_date', '<', now());
    }

    /**
     * Scope a query to filter by active orders (limit_date has not passed).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('limit_date', '>=', now());
    }

    /**
     * Check if the physical payment order is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the physical payment order is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * Check if the physical payment order is canceled.
     */
    public function isCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    /**
     * Check if the physical payment order is expired.
     */
    public function isExpired(): bool
    {
        return $this->limit_date && $this->limit_date->isPast();
    }

    /**
     * Get validation rules.
     *
     * @param bool $isUpdate
     * @return array<string, array<int, string>>
     */
    public static function rules(bool $isUpdate = false): array
    {
        $rules = [
            'order_id' => ['required', 'exists:orders,id'],
            'status' => ['required', 'string', 'in:pending,confirmed,canceled'],
        ];

        if ($isUpdate) {
            // En actualización, limit_date puede ser cualquier fecha (para permitir extender o ajustar)
            $rules['limit_date'] = ['required', 'date'];
        } else {
            // En creación, limit_date debe ser futura
            $rules['limit_date'] = ['required', 'date', 'after:now'];
        }

        // creation_date y update_date no se validan porque se establecen automáticamente
        // pero se permiten en caso de que se necesite establecer manualmente
        $rules['creation_date'] = ['nullable', 'date'];
        $rules['update_date'] = ['nullable', 'date'];

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
            'order_id.required' => 'La orden es obligatoria.',
            'order_id.exists' => 'La orden seleccionada no existe.',
            'limit_date.required' => 'La fecha límite es obligatoria.',
            'limit_date.date' => 'La fecha límite debe ser una fecha válida.',
            'limit_date.after' => 'La fecha límite debe ser posterior a la fecha actual.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser: pendiente, confirmado o cancelado.',
            'creation_date.date' => 'La fecha de creación debe ser una fecha válida.',
            'update_date.date' => 'La fecha de actualización debe ser una fecha válida.',
        ];
    }
}
