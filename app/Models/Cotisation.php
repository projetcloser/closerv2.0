<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*{
    "cashflow_id": [INT],
    "pay_year": [STRING],
    "ref_ing_cost": [STRING],
    "member_id": [INT],
    "amount": [INT],
    "pay": [INT],
    "author": [STRING],
    "personnel_id": [INT]
} */

class Cotisation extends Model
{
    use HasFactory;
    protected $table = 'cotisations';
    protected $attributes = [
        'status' => 'OK',
        'open_close' => 0,
    ];
    protected $fillable = ['cashflow_id', 'pay_year', 'ref_ing_cost', 'member_id', 'amount', 'pay', 'status', 'author', 'open_close'];
    // , 'staff_id'

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
