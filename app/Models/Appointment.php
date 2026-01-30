<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_time',
        'status',
        'notes',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
