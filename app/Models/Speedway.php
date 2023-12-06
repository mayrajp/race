<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speedway extends Model
{
    use HasFactory;

    protected $table = 'speedways';

    protected $fillable = [
        'name', 'kilometers', 'in_maintenance', 'type'
    ];

    public function races()
    {
        return $this->hasMany(Race::class);
    }
}
