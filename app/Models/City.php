<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
{
    "id": [INT],
    "country_id": [INT],
    "name": [STRING]
}
 */

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
}
