<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'model', 'brand', 'year', 'color', 'speedway_types'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

}
