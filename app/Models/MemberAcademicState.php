<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
{
    "member_id": [INT],
    "lastname": [STRING],
    "firstname": [STRING],
    "username": [STRING],
    "email": [STRING],
    "birthday": [STRING],
    "gender": ['male', 'female'],
    "address": [STRING],
    "country_id": [INT],
    "city_id": [INT],
    "neighborhood": [STRING],
    "phone": [STRING],
    "biography": [STRING],
    "avatar64": [STRING]
}

*/

class MemberAcademicState extends Model
{
    use HasFactory;
    protected $table = 'member_academic_states';
    protected $fillable = ['member_id', 'lastname', 'firstname', 'username', 'email', 'birthday', 'gender', 'address', 'country_id', 'city_id', 'neighborhood', 'phone'];

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id')->select('id', 'name');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id')->select('id', 'name');
    }
}
