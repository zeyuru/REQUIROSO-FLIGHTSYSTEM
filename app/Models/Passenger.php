<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'passport_number', 'nationality', 'dob', 'phone_number'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
