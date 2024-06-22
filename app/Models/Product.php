<?php

namespace App\Models;

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
}
