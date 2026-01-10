<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedUnit extends Model
{
    use HasFactory;

    /**
     * Fillable fields
     * These are the properties that can be mass-assigned via create() or update().
     * In OOP terms: these are the “attributes” of our AssignedUnit object.
     */
    protected $fillable = [
        'product_id',   // Which product this unit belongs to
        'unit_id',      // Which unit (e.g., box, piece)
        'content',      // Extra description or details
        'price',        // Price for this assigned unit
    ];

    /**
     * Relationships
     */

    // AssignedUnit belongs to a Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // AssignedUnit belongs to a Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
