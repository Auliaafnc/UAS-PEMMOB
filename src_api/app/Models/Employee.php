<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory, HasRoles, Notifiable;

    protected $guard = [];

    protected $fillable = [
        'phone',
        'branch_company_id',
        'department_id',
        'employee_code',
        'user_id',
        'order_id',
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {
            $employee->employee_code = 'EMP-'.Str::padLeft(Employee::max('id') + 1, 5, '0');
        });
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function branch_company()
    {
        return $this->belongsTo(BranchCompany::class);
    }

    public function client()
    {
        return $this->hasMany(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // public function tasks()
    // {
    //     return $this->hasMany(Task::class);
    // }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
