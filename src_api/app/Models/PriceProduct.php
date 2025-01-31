<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceProduct extends Model
{
    use HasFactory;

    protected $guard = [];

    protected $fillable = [
        'price',
        'price_minimal',
        'price_maximal',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
