<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAttestation extends Model
{
    use HasFactory;
    protected $table = 'company_attestations';
    protected $fillable = ['member_id', 'payment_amount', 'cash_register_id', 'year', 'company_id', 'motif'];

    public function cash_register()
    {
        return $this->belongsTo('App\Models\CashRegister', 'cash_register_id')->select('id', 'name');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id')->select('id', 'name');
    }
}
