<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeInspectionPhoto extends Model
{
    protected $fillable = [
        'intake_inspection_id',
        'inspection_zone_id',
        'path',
    ];

    public function inspection()
    {
        return $this->belongsTo(IntakeInspection::class, 'intake_inspection_id');
    }

    public function zone()
    {
        return $this->belongsTo(InspectionZone::class, 'inspection_zone_id');
    }
}
