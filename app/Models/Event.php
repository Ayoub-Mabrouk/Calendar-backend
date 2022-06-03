<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
    protected $fillable = [
        'start_time',
        'end_time',
        'description',
    ];
}
