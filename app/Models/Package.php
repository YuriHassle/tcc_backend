<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'inn_id',
        'name',
        'max_guests',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
