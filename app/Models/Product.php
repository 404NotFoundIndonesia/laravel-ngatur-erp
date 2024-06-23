<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sku', 'description', 'specification', 'status',
        'height', 'width', 'length', 'dimension_unit', 'weight', 'weight_unit',
        'currency', 'original_price', 'sale_price', 'product_cost',
        'pre_order', 'allow_cod', 'contains_hazardous_material',
    ];

    protected $casts = [
        'pre_order' => 'boolean',
        'allow_cod' => 'boolean',
        'contains_hazardous_material' => 'boolean',
    ];

    protected $appends = [
        'last_updated_at',
    ];

    public function lastUpdatedAt(): Attribute
    {
        return new Attribute(
            get: fn () => $this->updated_at->diffForHumans(),
        );
    }

    public function scopeStatus(Builder $query, ?string $status)
    {
        $query->when($status && $status !== 'all', function (Builder $query) use ($status) {
            return $query->where('status', $status);
        });
    }

    public function scopeSearch(Builder $query, ?string $search)
    {
        $query->when($search, function (Builder $query) use ($search) {
            return $query->where('name', 'LIKE', $search.'%')
                ->orWhere('sku', $search);
        });
    }

    public function scopeRender(Builder $query, ?int $size)
    {
        return $query->paginate($size ?? 10)->withQueryString();
    }
}
