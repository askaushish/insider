<?php

use Illuminate\Database\Seeder;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            for($j = 1; $j <= 10; $j++){
                DB::table('players')->insert([
                    'first_name' => "Team {$i}",
                    'last_name' => "Player {$j}",
                    'team_id' => $i
                ]);
            }
        }
    }
}
