<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'work_orders';

    protected $fillable = [
        'intake_sheet_id',
        'status',
        'assigned_at',
        'started_at',
        'finished_at',
        'description',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function intakeSheet()
    {
        return $this->belongsTo(IntakeSheet::class);
    }

    public function technicians()
    {
        return $this->belongsToMany(
            Profile::class,
            'work_order_technician'
        )->withTimestamps();
    }

    public function workTypes()
    {
        return $this->belongsToMany(WorkType::class);
    }
    public function proforma()
    {
        return $this->hasOne(Proforma::class);
    }
}
