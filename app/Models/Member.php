<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = ['matricule', 'lastname', 'firstname', 'email', 'order_number', 'phone', 'phone_2', 'folder', 'picture', 'debt'];
}
