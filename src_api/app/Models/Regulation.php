<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    use HasFactory;

    protected $guard = [];

    protected $fillable = [
        'name',
        'year',
        'details',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_regulation');
    }
}
