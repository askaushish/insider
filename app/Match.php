<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'first_team',
        'second_team',
        'round_number',
        'status'
    ];
}
