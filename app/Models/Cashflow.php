<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use HasFactory;
    protected $table = 'cashflows';
    protected $fillable = ['code', 'name', 'staff_id', 'balance',  'open_close'];

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'staff_id')->select('id', 'lastname', 'firstname');
    }
}
