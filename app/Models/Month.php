<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    protected $fillable = ['month'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
