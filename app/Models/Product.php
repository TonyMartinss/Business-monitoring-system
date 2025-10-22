<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'selling_price',
        'purchase_price',
        'category_id',
        'supplier_id',
        'reorder_level',
        'damaged_quantity',
        'barcode',
        'expiry_date',
    ];

    protected $dates = ['expiry_date'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    // In app/Models/Product.php
    public function sales()
    {
        return $this->hasMany(\App\Models\Sale::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}