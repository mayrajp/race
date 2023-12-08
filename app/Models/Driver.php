<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';

    protected $fillable = [
        'name', 'document', 'number', 'is_active'
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    
    public function races() : BelongsToMany
    {
        return $this->belongsToMany(Races::class, 'race_drivers', 'driver_id', 'race_id');
    }
}
