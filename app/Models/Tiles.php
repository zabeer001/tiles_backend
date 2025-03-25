<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'grid_category',
        'image',
    ];

    public function categories()
    {
        // Specify the relationship using belongsToMany
        return $this->belongsToMany(Category::class, 'category_tile', 'tile_id', 'category_id')
                    ->withTimestamps();  // Optionally include timestamps if needed
      
    }
    
    

}
