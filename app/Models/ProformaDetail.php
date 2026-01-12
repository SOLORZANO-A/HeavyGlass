<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProformaDetail extends Model
{
    protected $table = 'proforma_details';

    protected $fillable = [
        'proforma_id',
        'item_description',
        'quantity',
        'unit_price',
        'line_total',
        'notes',
        'type',
    ];

    // RELATIONSHIPS
    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }
}
