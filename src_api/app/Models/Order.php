<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'employee_id',
        'discount_id',
        'client_id',
        'branch_company_id',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            $maxId = Order::max('id');
            if ($order->status === 'Purchase Order') {

                $order->order_number = 'PO-'.Str::padLeft($maxId + 1, 10, '0');
            } else {
                $order->order_number = 'SO-'.Str::padLeft($maxId + 1, 10, '0');
            }
        });

        static::creating(function ($order) {
            if (empty($order->employee_id)) {
                $order->employee_id = auth()->user()->employee->id; // Pastikan employee dari user yang login
            }
        });

        static::updating(function ($order) {
            $maxId = Order::max('id');
            if ($order->isDirty('status')) {
                if ($order->status === 'Purchase Order') {
                    $order->order_number = 'PO-'.Str::padLeft($maxId + 1, 10, '0');
                } else {
                    $order->order_number = 'SO-'.Str::padLeft($maxId + 1, 10, '0');
                }
            }
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function branchCompany()
    {
        return $this->belongsTo(BranchCompany::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Scope untuk mengambil Client berdasarkan user yang login
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('employee', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }
}
