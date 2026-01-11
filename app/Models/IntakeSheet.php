<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeSheet extends Model
{
    protected $table = 'intake_sheets';

    protected $fillable = [
        'vehicle_id',
        'advisor_id',
        'entry_at',
        'km_at_entry',
        'fuel_level',
        'has_dents',
        'has_scratches',
        'has_cracks',
        'observations',
        'valuables',
        'client_signature_path',
        'estimated_delivery_date',
    ];

    protected $casts = [
        'has_dents' => 'boolean',
        'has_scratches' => 'boolean',
        'has_cracks' => 'boolean',
        'entry_at' => 'datetime',
        'estimated_delivery_date' => 'date',
    ];


    // RELATIONS
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function photos()
    {
        return $this->hasMany(IntakePhoto::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }
}
