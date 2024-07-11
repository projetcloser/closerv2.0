<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = ['social_reason', 'author', 'phone', 'nui', 'type', 'country_id', 'city_id', 'contact_person', 'contact_person_phone'];

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id')->select('id', 'name');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id')->select('id', 'name');
    }
}
