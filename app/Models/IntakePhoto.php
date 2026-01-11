<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakePhoto extends Model
{
    protected $fillable = [
        'intake_sheet_id',
        'path',
        'type',
        'description',
    ];

    public function intakeSheet()
    {
        return $this->belongsTo(IntakeSheet::class);
    }
}
