<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'team_id',
        'location',
        'name',
        'color',
        'alternateColor',
        'url',
        'logo',
        'homeAway'
    ];
}
