<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;
    // Allow mass assignment for these fields
    protected $fillable = [
        'employee_id', 
        'shift_id', 
        'month_id',
        'attendance_time', 
        'late', 
        'late_count', 
        'start_time', 
        'end_time'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Define the relationship to Shift (optional, but relevant if shifts are used)
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

     
    public function month()
    {
        return $this->belongsTo(Month::class);
    }
}
