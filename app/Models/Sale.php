<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * Get the product associated with the sale.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
