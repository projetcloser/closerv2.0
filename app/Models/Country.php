<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
{
    "id": [INT],
    "code": [STRING],
    "name": [STRING]
}
*/

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code'
    ];
}
