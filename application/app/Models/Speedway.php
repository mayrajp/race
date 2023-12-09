<?php

namespace App\Models;

use App\Enums\SpeedwaysTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speedway extends Model
{
    use HasFactory;

    protected $table = 'speedways';

    protected $fillable = [
        'name', 'in_maintenance', 'type', 'is_active'
    ];

    public function races()
    {
        return $this->hasMany(Race::class);
    }

    protected $casts = [
        'type' => SpeedwaysTypesEnum::class,
    ];
}
