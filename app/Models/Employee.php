<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // One-to-one relationship with Shift
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    // One-to-one relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
    
    public function months()
    {
        return $this->belongsToMany(Month::class);
    }
}
