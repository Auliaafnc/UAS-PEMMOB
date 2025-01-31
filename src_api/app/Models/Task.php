<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'order_id',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // public function employee()
    // {
    //     return $this->belongsTo(Employee::class);
    // }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('order.employee', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }
}
