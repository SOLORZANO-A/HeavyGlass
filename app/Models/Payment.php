<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
        const STATUS_VALID = 'valid';
        const STATUS_CANCELLED= 'cancelled';

    protected $table = 'payments';

    protected $fillable = [
        'proforma_id',
        'cashier_id',
        'amount',
        'payment_method',
        'description',

        // 🧾 COMPROBANTE
        'receipt_number',
        'issued_at',
        'paid_at',
        'status',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'paid_at'   => 'datetime',
    ];

    public function scopeValid($query)
    {
        return $query->where('status', self::STATUS_VALID);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }



    // RELATIONSHIPS

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }

    public function cashier()
    {
        return $this->belongsTo(Profile::class, 'cashier_id');
    }
}
