<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    public $timestamps = false;
    protected $fillable = ['room_number'];

    public function timeSlots(): HasMany
    {
        return $this->hasMany(RoomTimeSlot::class);
    }
}
