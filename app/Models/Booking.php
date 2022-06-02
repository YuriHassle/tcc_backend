<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'holder_name',
        'holder_email',
        'holder_phone',
        'checkin',
        'checkout',
        'guest_quantity',
        'is_cancelled',
        'details'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
