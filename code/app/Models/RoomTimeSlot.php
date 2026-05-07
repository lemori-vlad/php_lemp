<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTimeSlot extends Model
{
    public $timestamps = false;
    protected $fillable = ['room_id', 'start_time', 'end_time', 'is_reserved', 'reserved_by_id'];
}
