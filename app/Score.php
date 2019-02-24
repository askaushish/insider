<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'match_id',
        'batting_team',
        'over_number',
        'batsmen',
        'bowler',
        'runs_scored',
        'wickets_fallen',
        'total_runs_till_this_over',
        'total_wickets_till_this_over'
    ];
}
