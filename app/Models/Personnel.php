<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    protected $table = 'personnels';
    protected $fillable = ['statut', 'lastname', 'firstname', 'email', 'date_card_validity', 'phone', 'father_name', 'father_phone', 'mother_name', 'birthday', 'place_birth', 'profession', 'genre', 'contract_type','marital_status','position','num_children','open_close', 'city_id', 'country_id'];

}
