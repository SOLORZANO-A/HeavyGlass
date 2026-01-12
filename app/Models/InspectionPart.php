<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionPart extends Model
{
    protected $table = 'inspection_parts';

    protected $fillable = [
        'inspection_zone_id',
        'name'
    ];

    // 🔗 Relaciones

    public function zone()
    {
        return $this->belongsTo(InspectionZone::class, 'inspection_zone_id');
    }

    public function inspectionItems()
    {
        return $this->hasMany(IntakeInspectionItem::class);
    }
}

