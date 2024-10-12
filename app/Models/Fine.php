<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*{
    "id": [INT],
    "member_id": [INT],
    "object": [STRING],
    "fine_date": [STRING],
    "amount": [STRING],
    "author": [STRING],
    "status": [0|1] //O - non payée, 1 - payée
}
*/

class Fine extends Model
{
    use HasFactory;
    protected $table = 'fines';
    protected $fillable = ['member_id', 'object', 'fine_date', 'amount', 'author', 'status'];
}
