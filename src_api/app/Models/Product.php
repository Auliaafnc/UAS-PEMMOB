<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guard = [];

    protected $fillable = ['name','category_product', 'category', 'regulation_id', 'type_product_id', 'description_product_id', 'parameter_id', 'methode_id', 'price_product_id'];

    public function typeProduct()
    {
        return $this->belongsTo(TypeProduct::class);
    }

    public function descriptionProduct()
    {
        return $this->belongsTo(DescriptionProduct::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function methode()
    {
        return $this->belongsTo(Methode::class);
    }

    public function priceProduct()
    {
        return $this->HasOne(PriceProduct::class);
    }

    public function regulations()
    {
        return $this->belongsToMany(Regulation::class, 'product_regulation');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product');
    }
}
