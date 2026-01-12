<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeInspectionItem extends Model
{
    protected $fillable = [
        'intake_inspection_id',
        'inspection_zone_id',
        'inspection_part_id',
        'change',
        'paint',
        'fiber',
        'dent',
        'crack',
        'notes',
    ];

    protected $casts = [
        'change' => 'boolean',
        'paint'  => 'boolean',
        'fiber'  => 'boolean',
        'dent'   => 'boolean',
        'crack'  => 'boolean',
    ];

    public function inspection()
    {
        return $this->belongsTo(IntakeInspection::class, 'intake_inspection_id');
    }

    public function zone()
    {
        return $this->belongsTo(InspectionZone::class, 'inspection_zone_id');
    }

    public function part()
    {
        return $this->belongsTo(InspectionPart::class, 'inspection_part_id');
    }
}
