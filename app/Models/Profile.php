<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'document',
        'email',
        'phone',
        'address',
        'staff_type',
        'specialization',
        'description',
    ];

    // RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A profile can have many work orders (if it's technician)

    public function workOrders()
    {
        return $this->belongsToMany(
            WorkOrder::class,
            'work_order_technician'
        )->withTimestamps();
    }
    
    public const TECHNICAL_SPECIALTIES = [
        'Pintura',
        'Chapisteria',
        'Fibra',
        'Enderezada',
    ];




    // Helper for Blade
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'cashier_id');
    }
}
