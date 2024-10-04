<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*{
    "matricule": [STRING],
    "lastname": [STRING],
    "firstname": [STRING],
    "email": [STRING],
    "order_number": [STRING],
    "phone": [STRING],
    "phone_2": [STRING],
    "folder": [LONGTEXT],
    "picture": [STRING],
    "debt": [INT]
}*/

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = ['matricule', 'lastname', 'firstname', 'email', 'order_number', 'phone', 'phone_2', 'folder', 'picture', 'debt'];
}
