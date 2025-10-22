<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransactionPayment;
use App\Models\Product;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'unit_price',
        'total_price',
        'customer_name',
        'customer_phone',
    ];

    // Automatically eager load these relationships
    protected $with = ['item', 'user', 'payments'];

    /**
     * Relationships
     */
    public function item()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(TransactionPayment::class);
    }

    /**
     * Total paid amount
     */
    public function getPaidAmountAttribute()
    {
        return $this->payments->sum('amount');
    }

    /**
     * Remaining balance
     */
    public function getBalanceAttribute()
    {
        return $this->total_price - $this->paid_amount;
    }

    /**
     * Is transaction fully cleared?
     */
    public function getIsClearedAttribute()
    {
        return $this->paid_amount >= $this->total_price;
    }

    /**
     * Total cost of this transaction (purchase_price * quantity)
     * Useful for admin profit calculation
     */
    public function getTotalCostAttribute()
    {
        return $this->quantity * ($this->item->purchase_price ?? 0);
    }

    /**
     * Auto-calculate unit_price and total_price before creating
     */
    protected static function booted()
    {
        static::creating(function ($transaction) {
            // Use item selling price if unit_price not provided
            if (empty($transaction->unit_price) && $transaction->item) {
                $transaction->unit_price = $transaction->item->selling_price;
            }

            // Calculate total price
            $transaction->total_price = $transaction->quantity * $transaction->unit_price;
        });

        static::updating(function ($transaction) {
            // Ensure total price is updated if quantity or unit_price changes
            $transaction->total_price = $transaction->quantity * $transaction->unit_price;
        });
    }
}
