<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $table = 'proformas';

    protected $fillable = [
        // RELACIÓN
        'work_order_id',

        // NUMERACIÓN
        'number',

        // CLIENTE
        'client_name',
        'client_document',
        'client_phone',
        'client_email',

        // VEHÍCULO
        'vehicle_brand',
        'vehicle_model',
        'vehicle_plate',

        // TOTALES
        'subtotal',
        'tax',
        'total',

        // OTROS
        'observations',
        'status',
        // firma
        'signature_status',
        'client_signature',
        'signed_at',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];
    public function isSigned(): bool
    {
        return $this->signature_status === 'signed';
    }

    public function isPendingSignature(): bool
    {
        return $this->signature_status === 'pending';
    }


    // RELATIONSHIPS

    public function intakeSheet()
    {
        return $this->belongsTo(IntakeSheet::class);
    }

    public function details()
    {
        return $this->hasMany(ProformaDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
