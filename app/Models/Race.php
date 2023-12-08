<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Race extends Model
{
    use HasFactory;

    protected $table = 'races';

    protected $fillable = [
        'name', 'start_date', 'end_date', 'prize_value', 'is_canceled', 'maximum_number_of_drivers'
    ];

    public function speedway()
    {
        return $this->belongsTo(Speedway::class);
    }
    
    public function drivers() : BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'race_drivers', 'race_id', 'driver_id');
    }

}
