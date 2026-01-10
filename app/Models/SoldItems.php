<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoldItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'selling_price',
        'total_price',
        'disc',
    ];

    /**
     * Relationship: SoldItem belongs to a Sale
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    /**
     * Relationship: SoldItem belongs to a Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
