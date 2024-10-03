<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'cashflow_id',
        'ref_dem_part',
        'member_id',
        'amount',
        'status',
        'date_certification',
        'personnel_id',
        'author',
        'open_close',
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
        return $this->belongsTo(Personnel::class);
    }
}
