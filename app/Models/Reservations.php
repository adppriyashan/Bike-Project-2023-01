<?php

namespace App\Models;

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
    ];
}
