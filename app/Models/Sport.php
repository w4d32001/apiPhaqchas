<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_morning',
        'price_evening',
        'image'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

}
