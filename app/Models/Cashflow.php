<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use HasFactory;
    protected $table = 'cashflows';
    protected $fillable = ['code', 'name', 'personnel_id', 'balance',  'open_close'];

    public function personnel()
    {
        return $this->belongsTo('App\Models\Personnel', 'personnel_id')->select('id', 'lastname', 'firstname');
    }

}
