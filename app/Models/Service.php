<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'inn_id',
        'name',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
