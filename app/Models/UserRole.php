<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'role_id'];

    // Définir la relation entre UserRole et Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Optionnel : Définir la relation entre UserRole et User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function roleDetails()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
