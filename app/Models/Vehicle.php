<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
<<<<<<< HEAD

=======
    
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
    protected $table = 'vehicles';

    protected $fillable = [
        'client_id',
        'brand',
        'model',
<<<<<<< HEAD
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


=======
        'color',
        'year',
        'plate',
        'vin',
        'chassis',
        'engine',
        'mileage',
        'status_id',
        'description',
    ];

>>>>>>> 964613b02c73302aea2dc33386313b314db28634
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
