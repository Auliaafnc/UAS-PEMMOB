<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchCompany extends Model
{
    use HasFactory;

    protected $guard = [];

    protected $fillable = [
        'name',
        'address',
        'email',
        'phone',
        'company_id',
        'department_id',
        'client_id',
        'employee_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->hasMany(Department::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function client()
    {
        return $this->hasMany(Client::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function typeProducts()
    {
        return $this->hasMany(TypeProduct::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('employee', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }
}
