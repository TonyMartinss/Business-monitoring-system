<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    // ✅ Define which fields can be mass-assigned
    protected $fillable = [
        'supplier_name',
        'product_id',
        'total_amount',
        'account_id',
        'purchase_date',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    // Account linked to this purchase
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}


 