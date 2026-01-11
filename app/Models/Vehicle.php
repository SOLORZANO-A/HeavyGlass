<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    protected $table = 'vehicles';

    protected $fillable = [
        'client_id',
        'brand',
        'model',
        'plate',
        'year',
        'color',
        'vin',
        'engine',
        'engine_number',
        'chassis',
        'chassis_number',
        'mileage',
        'description',
    ];


    // RELATIONSHIPS
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function intakeSheets()
    {
        return $this->hasMany(IntakeSheet::class);
    }

    // public function status()
    // {
    //     return $this->belongsTo(VehicleStatus::class, 'status_id');
    // }
}
