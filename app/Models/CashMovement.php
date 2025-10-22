<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashMovement extends Model
{
    protected $fillable = [
        'type',
        'account_id',
        'amount',
        'balance_before',
        'balance_after',
        'reason',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    // app/Models/CashMovement.php
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
