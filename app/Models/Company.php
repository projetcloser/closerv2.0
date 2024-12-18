<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/*{
    "company_name": [STRING],
    "author": [STRING],
    "company_type": [PUBLIC | PRIVEE],
    "email": [STRING],
    "nui": [STRING],
    "country_id": [INT],
    "city_id": [INT],
    "phone": [STRING],
    "contact_person": [STRING],
    "contact_person_phone": [STRING],
    "neighborhood": [STRING]
}
*/

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = ['social_reason', 'author', 'phone', 'nui', 'country_id', 'city_id', 'contact_person', 'contact_person_phone', 'company_type', 'neighborhood','email'];

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id')->select('id', 'name');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id')->select('id', 'name');
    }
}
