<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
{
    "id": [INT],
    "matricule": [STRING],
    "lastname": [STRING],
    "firstname": [STRING],
    "genre": [MALE|FEMALE],
    "email": [STRING],
    "order_number": [STRING],
    "phone": [STRING],
    "phone_2": [STRING],
    "city_id": [INT],
    "group_id": [INT],
    "folder": [LONGTEXT],
    "picture": [STRING],
    "status": [INT], //1 - actif (default) et 0 - décédé
    "author": [STRING]
}
 */

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = ['matricule', 'lastname', 'firstname', 'email', 'order_number', 'phone', 'phone_2', 'folder', 'picture', 'debt', 'gender', 'city_id', 'group_id','author'];
}

