<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guard = [];

    protected $fillable = [
        'name',
        'branch_company_id',
        'department_id',
        'client_id',
        'employee_id',
    ];

    public function branch_company()
    {
        return $this->belongsTo(BranchCompany::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function client()
    {
        return $this->hasMany(Client::class);
    }

    public function branch_companies()
    {
        return $this->belongsToMany(BranchCompany::class, 'department_branch_company', 'department_id', 'branch_company_id');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('employee', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }
}
