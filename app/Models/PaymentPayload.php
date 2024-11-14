<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPayload extends Model
{
    use HasFactory;
    protected $table = 'payment_payloads';
    protected $fillable = ['member_id', 'form_data', 'request_result'];
}
