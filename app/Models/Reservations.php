<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;

    public static $status = [1 => 'Active', 2 => 'Inactive'];

    protected $fillable = [
        'bike',
        'user',
        'status',
        'total',
        'ride_at',
        'drop_at',
        'card_last_numbers',
        'is_paid',
        'from_lng',
        'from_ltd',
        'to_lng',
        'to_ltd',
        'distance'
    ];

    public function bikeData()
    {
        return $this->hasOne(Bike::class, 'id', 'bike');
    }

    // protected function total(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => format_currency($value),
    //     );
    // }

    public function history()
    {
        return $this->hasMany(History::class, 'reservation', 'id');
    }
}
