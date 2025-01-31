<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProduct extends Model
{
    use HasFactory;

    protected $guard = [];

    protected $fillable = [
        'name',
        'branch_company_id',
    ];

    public function branch_companies()
    {
        return $this->belongsTo(BranchCompany::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function branch_company()
    {
        return $this->belongsTo(BranchCompany::class);
    }
}
