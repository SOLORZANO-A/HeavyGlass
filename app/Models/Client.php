<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
    'first_name',
    'last_name',
    'document',
    'phone',
    'email',
    'address',
    'client_type',
    'description',
    'id_copy_path',
<<<<<<< HEAD
    'reference_number'
=======
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
];


    // RELATIONSHIPS
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    // Helper for Blade
    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
