<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
{
    "id": [INT],
    "object": [STRING],
    "body": [STRING],
    "group_id": [INT],
    "author": [STRING],
    "status": [0|1] //O - non lu (default), 1 - lu
}
 */

class Announcement extends Model
{
    use HasFactory;
    protected $table = 'annoucements';
    protected $fillable = ['object', 'body', 'author', 'group_id'];
}
