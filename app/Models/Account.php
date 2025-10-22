<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name',
        'type',
        'number',
        'balance',
    ];

    public function cashMovements()
    {
        return $this->hasMany(CashMovement::class);
    }
}
