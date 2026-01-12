<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionZone extends Model
{
    protected $table = 'inspection_zones';

    protected $fillable = [
        'name',
        'order'
    ];

    // 🔗 Relaciones

    public function parts()
    {
        return $this->hasMany(InspectionPart::class);
    }

    public function inspections()
    {
        return $this->hasMany(IntakeInspection::class);
    }
}

