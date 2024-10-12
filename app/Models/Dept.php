<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    use HasFactory;
    protected $table = 'debts';
    protected $fillable = ['cashflow_id', 'pay_year', 'ref_ing_cost', 'member_id', 'amount', 'pay', 'status', 'personnel_id', 'author'];
}
