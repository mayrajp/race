<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    protected $table = 'respocibles';

    protected $fillable = [
        'name', 'document', 'phone'
    ];
    
    public function races()
    {
        return $this->hasMany(Race::class);
    }
}
