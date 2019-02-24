<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'team_name',      
    ];
    
    /**
     * Get the players for the team.
     */
    public function players()
    {
        return $this->hasMany('App\Player', 'team_id','team_id');
    }
}
