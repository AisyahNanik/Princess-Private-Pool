<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Allotment;
use App\Models\Booking;


class Swimmingpool extends Model
{
    protected $fillable = [
        'user_id',
        'image',
        'name',
        'description',
        'location',
        // 'price_per_person',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function allotments()
    {
        return $this->hasMany(Allotment::class, 'swimmingpool_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
