<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeInspection extends Model
{
    protected $table = 'intake_inspections';

    protected $fillable = [
        'intake_sheet_id',
        'observations',
        'status'
    ];
    protected $casts = [
        'observations' => 'array',
    ];

    // 🔗 Relaciones

    public function intakeSheet()
    {
        return $this->belongsTo(IntakeSheet::class);
    }

    public function items()
    {
        return $this->hasMany(IntakeInspectionItem::class);
    }

    public function photos()
    {
        return $this->hasMany(IntakeInspectionPhoto::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
