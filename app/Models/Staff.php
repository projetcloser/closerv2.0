<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*{
    "lastname": [STRING],
    "firstname": [STRING],
    "email": [STRING],
    "date_card_validity": [STRING],
    "phone": [STRING],
    "phone_2": [STRING],
    "father_name": [STRING],
    "father_phone": [STRING],
    "mother_name": [STRING],
    "birthday": [STRING],
    "place_birth": [STRING],
    "profession": [STRING],
    "genre": ["Male" | "Female"],
    "contract_type": ["Permanent"| ...],
    "marital_status": ["Married"| ...],
    "position": [STRING],
    "num_children": [STRING],
    "city_id": [INT],
    "country_id": [INT],
    "neighbourhood": [STRING],
    "attachment_file": [STRING]
}
 */

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $fillable = ['statut', 'lastname', 'firstname', 'email', 'date_card_validity', 'phone', 'father_name', 'father_phone', 'mother_name', 'birthday', 'place_birth', 'profession', 'genre', 'contract_type', 'marital_status', 'position', 'num_children', 'open_close', 'city_id', 'country_id', 'phone_2', 'neighbourhood', 'attachment_file'];
}
