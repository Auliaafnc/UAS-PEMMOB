<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;

    protected $guard = [];

    protected $fillable = [
        'client_id',
        'name',
        'logo',
        'email',
        'phone',
        'address',
        'branch_company_id',
        'employee_id',
    ];

    protected static function booted()
    {
        static::creating(function ($client) {
            $client->client_id = 'CLIENT-'.Str::padLeft(Client::max('id') + 1, 5, '0');
        });
    }

    public function branch_company()
    {
        return $this->belongsTo(BranchCompany::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Scope untuk mengambil Client berdasarkan user yang login
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('employee', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }
}
