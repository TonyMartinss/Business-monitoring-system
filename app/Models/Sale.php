<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'sale_date',
        'total',
        'discount',
        'net',
        'paid',
        'due',
        'sale_type',
        'account_id',
        'customer_id',
    ];

    // Sale belongs to an Account
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    // Sale belongs to a Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}