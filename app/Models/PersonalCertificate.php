<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*{
    "cashflow_id": [INT],
    "member_id": [INT],
    "personnel_id": [INT],
    "ref_dem_part": [STRING],
    "amount": [INT],
    "status": ["envoyer"],
    "author": [STRING],
    "date_certification": [STRING],
    "object": [STRING]
} */

class PersonalCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'cashflow_id',
        'ref_dem_part',
        'member_id',
        'amount',
        'status',
        'certification_date',
        'staff_id',
        'author',
        'open_close',
        'object'
    ];

    protected $casts = [
        'open_close' => 'boolean',
        'date_certification' => 'date',
        'amount' => 'integer',
    ];

    // Relations
    public function cashflow()
    {
        return $this->belongsTo(Cashflow::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function personnel()
    {
        return $this->belongsTo(Staff::class);
    }
}
