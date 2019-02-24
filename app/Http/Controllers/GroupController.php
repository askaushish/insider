<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Team;
use App\Match;

class GroupController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $matches = Match::all();

        return view('groups.index', compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'group_name' => 'required',
            'number_of_teams' => 'required'
        ]);

        try {
            $this->scheduleMatches($request);
            return redirect('/groups')->with('success', 'Yay! Group created and matches has been scheduled.');
        } catch (\Exception $e) {
            return redirect('/groups/create')->withErrors(['msg', $e->getMessage(). "at line ". $e->getLine()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function scheduleMatches(Request $request) {
        $numberOfTeams = $request->get('number_of_teams');
        $teamsInGroup = $this->validateTeamCounts($numberOfTeams);

        DB::beginTransaction();
        try {
            DB::table('groups')->insert(['group_name' => $request->get('group_name')]);
            $rounds = $this->getMatches($teamsInGroup);
            
            foreach ($rounds as $matches) {
                foreach ($matches as $match) {
                    DB::table('matches')->insert($match);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function validateTeamCounts($numberOfTeams) {
        if ($numberOfTeams % 2 !== 0) {
            throw new \Exception("Number of teams should be an even number");
        }
        $teams = Team::all();
        foreach ($teams as $team) {
            $teamNamesArray[] = $team['team_name'];
        }
        if (count($teams) < $numberOfTeams) {
            throw new \Exception("Total teams available is less than given number.");
        }
        return $this->pickRandomElementsFromArray($teamNamesArray, $numberOfTeams);
    }

    public function pickRandomElementsFromArray($list, $numberOfElements) {
        $randomArray = [];
        while (count($randomArray) < $numberOfElements) {
            $randomKey = mt_rand(0, count($list) - 1);
            $randomArray[$randomKey] = $list[$randomKey];
        }
        return $randomArray;
    }

    public function getMatches($teams) {
        $rounds = [];
        $away = array_splice($teams, (count($teams) / 2));
        $home = $teams;
        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $rounds[$i][$j]["first_team"] = $home[$j];
                $rounds[$i][$j]["second_team"] = $away[$j];
                $rounds[$i][$j]["round_number"] = $i+1;
            }
            if (count($home) + count($away) - 1 > 2) {
                $elem =array_splice($home, 1, 1);
                array_unshift($away, array_shift($elem));
                array_push($home, array_pop($away));
            }
        }
        return $rounds;
    }

}
