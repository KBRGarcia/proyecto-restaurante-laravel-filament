<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /**
     * Status constants.
     */
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_OUT_OF_STOCK = 'out of stock';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
        'status',
        'preparation_time',
        'ingredients',
        'is_special',
        'creation_date',
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
        'price' => 'decimal:2',
        'preparation_time' => 'integer',
        'is_special' => 'boolean',
        'creation_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include inactive products.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /**
     * Scope a query to only include out of stock products.
     */
    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_OUT_OF_STOCK);
    }

    /**
     * Scope a query to only include special products.
     */
    public function scopeSpecial(Builder $query): Builder
    {
        return $query->where('is_special', true);
    }

    /**
     * Scope a query to only include products from a specific category.
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to order products by price.
     */
    public function scopeOrderByPrice(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('price', $direction);
    }

    /**
     * Scope a query to order products by preparation time.
     */
    public function scopeOrderByPreparationTime(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('preparation_time', $direction);
    }

    /**
     * Check if the product is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the product is inactive.
     */
    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    /**
     * Check if the product is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->status === self::STATUS_OUT_OF_STOCK;
    }

    /**
     * Check if the product is special.
     */
    public function isSpecial(): bool
    {
        return $this->is_special;
    }
}
