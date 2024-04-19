<?php

namespace App\Models;

use App\Traits\Models\HasMetrics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RosterEvent extends Model
{
    use HasFactory, HasMetrics;

    const FLIGHT = 'FLT';
    const STANDBY = 'SBY';
    const OFF = 'OFF';
    const UNK = 'UNK';

    const EVENTS = [ self::FLIGHT, self::STANDBY, self::OFF, self::UNK];

     /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'departure' => 'datetime',
        'arrival' => 'datetime',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'event_date' => 'datetime',
    ];
}
