<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*{
    "member_id": [INT],
    "receipt_number": [STRING],
    "step": [INT],
    "author": [STRING],
    "city_id": [INT],
    "phone": [STRING],
    "year": [INT]
}*/

class Stamp extends Model
{
    use HasFactory;
    protected $table = 'stamps';
    protected $fillable = ['member_id', 'receipt_number', 'author', 'city_id', 'phone', 'year'];
    // , 'step'

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id')->select('id', 'name');
    }
}
