<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function responsible()
    {
        return $this->belongsTo(Responsible::class);
    }

}
