<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{

    use HasFactory;
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function events()
    {
        return $this->hasMany(Event::class);
    }
    protected $fillable = [
        'name',
    ];
}
