<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*{
    "member_id": [INT],
    "payment_amount": [INT],
    "cash_register_id": [INT],
    "year": [STRING],
    "company_id": [INT],
    "motif": [STRING],
    "step": [STRING] // 1: non payé, 2: initier, 3: payé
}
 */

class CompanyAttestation extends Model
{
    use HasFactory;
    protected $table = 'company_attestations';
    protected $fillable = ['member_id', 'payment_amount','cashflow_id',  'year', 'company_id', 'motif'];
    // 'cash_register_id',

    // public function cash_register()
    // {
    //     return $this->belongsTo('App\Models\CashRegister', 'cash_register_id')->select('id', 'name');
    // }
     // Relations
     public function cashflow()
     {
         return $this->belongsTo(Cashflow::class);
     }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id')->select('id', 'name');
    }
}
