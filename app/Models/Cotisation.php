<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    use HasFactory;
    protected $table = 'cotisations';
    protected $fillable = ['cashflow_id', 'pay_year', 'ref_ing_cost', 'member_id', 'amount', 'pay', 'status', 'personnel_id', 'author', 'open_close'];

    public function cashflow()
    {
        return $this->belongsTo('App\Models\Cashflow', 'cashflow_id')->select('id', 'name');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id')->select('id', 'lastname', 'firstname');
    }

    public function personnel()
    {
        return $this->belongsTo('App\Models\Personnel', 'personnel_id')->select('id', 'lastname', 'firstname');
    }
}
