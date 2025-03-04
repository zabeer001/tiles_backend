<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    // Define the fillable properties
    protected $fillable = [
        'employee_id', 
        'salary', 
        'shift_id', 
        'month_id', 
        'late_count', 
        'salary_deduction', 
        'payable'
    ];

    // Define the relationship with the Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
