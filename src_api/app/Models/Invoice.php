<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'order_id',
        'name',
        'status',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function branchCompanyThroughTask()
    {
        return $this->hasOneThrough(
            BranchCompany::class,
            Employee::class,
            'id', // Foreign key on the employees table...
            'id', // Foreign key on the branch_companies table...
            'task_id', // Local key on the invoices table...
            'branch_company_id' // Local key on the employees table...
        );
    }

    // Relasi untuk mengambil BranchCompany melalui Order -> Employee -> BranchCompany
    public function branchCompanyThroughOrder()
    {
        return $this->hasOneThrough(
            BranchCompany::class,
            Employee::class,
            'id', // Foreign key on the employees table...
            'id', // Foreign key on the branch_companies table...
            'order_id', // Local key on the invoices table...
            'branch_company_id' // Local key on the employees table...
        );
    }
}
