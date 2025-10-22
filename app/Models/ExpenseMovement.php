<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseMovement extends Model
{
    use HasFactory;

    // ✅ Fields that can be mass-assigned
    protected $fillable = [
        'account_id', // Link to account
        'amount',     // Expense amount
        'reason',     // Reason for expense
        'user_id',    // Who recorded it
    ];

    // Optional: Relationships

    // Account linked to this expense
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // User who recorded the expense
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}