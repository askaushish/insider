<?php

namespace App\Http\Controllers;

use App\Match;
use App\Player;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Exception;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $match = Match::find($id);
            if($match['status'] == 0 ){
                throw new Exception("Match has not started yet");
            }
            $firstTeam = $match['first_team'];
            $secondTeam = $match['second_team'];
            $matchScoreRecords = $match->scores;
            
            foreach($matchScoreRecords as $record){
                if($record->batting_team == $secondTeam) {
                    $secondInningsReords [] = $record;
                } else {
                    $firstInningsReords [] = $record;
                }
            }
            return view('matches.show', compact('firstInningsReords', 'secondInningsReords', 'firstTeam', 'secondTeam'));
        } catch(Exception $e) {
            return redirect('/groups')->withErrors(['msg', $e->getMessage() ]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $match = Match::find($id);
            $firstTeam = Team::where('team_name', $match['first_team'])->first();
            if($match['status'] != 0){
                throw new Exception("Match already finished");
            }
            if(!$firstTeam instanceof Team){
                throw new Exception("First team not valid");
            }

            $secondTeam = Team::where('team_name', $match['second_team'])->first();
            if(!$secondTeam instanceof Team){
                throw new Exception("Second team not valid");
            }
            $this->startMatch($id, $firstTeam, $secondTeam);
            return redirect('/groups')->with('success', 'Yay! Match completed.');
        } catch (Exception $e) {
            return redirect('/groups')->withErrors(['msg', $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function startMatch($matchId, $firstTeam, $secondTeam) 
    {
        $firstTeamPlayers = $firstTeam->players;
        $secondTeamPlayers = $secondTeam->players;
        DB::beginTransaction();
        try {
            // 1st Innings starts
            $totalRunsTillThisOver1st = 0;
            for($i= 1; $i <= 20; $i++){
                $runScoredThisOver = rand(0, 15);
                
                $totalRunsTillThisOver1st = $totalRunsTillThisOver1st + $runScoredThisOver;
                $score = [
                    'match_id' => $matchId,
                    'batting_team' => $firstTeam['team_name'],
                    'over_number' => $i,
                    'batsmen' => $this->pickRandomPlayer($firstTeamPlayers),
                    'bowler' => $this->pickRandomPlayer($secondTeamPlayers),
                    'runs_scored' => $runScoredThisOver,
                    'total_runs_till_this_over' => $totalRunsTillThisOver1st,
                ];
                DB::table('scores')->insert($score);
            }
            // 2nd Innings starts
            $totalRunsTillThisOver2nd = 0;
            for($i= 1; $i <= 20; $i++){
                $runScoredThisOver = rand(0, 15);
                $totalRunsTillThisOver2nd = $totalRunsTillThisOver2nd + $runScoredThisOver;
                $score = [
                    'match_id' => $matchId,
                    'batting_team' => $secondTeam['team_name'],
                    'over_number' => $i,
                    'batsmen' => $this->pickRandomPlayer($secondTeamPlayers),
                    'bowler' => $this->pickRandomPlayer($firstTeamPlayers),
                    'runs_scored' => $runScoredThisOver,
                    'total_runs_till_this_over' => $totalRunsTillThisOver2nd,
                ];
                DB::table('scores')->insert($score);
            }

            //Update Match status
            DB::table('matches')->where('id', $matchId)->update(array('status' => 1));
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        
        
    }
    
    public function pickRandomPlayer($playerList) {
        $randomKey = mt_rand(0, count($playerList) - 1);
        return $playerList[$randomKey]['first_name']. " ". $playerList[$randomKey]['last_name'];
    }
}
