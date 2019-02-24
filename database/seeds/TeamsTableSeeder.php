<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            'team_name' => "Australia"
        ]);
        DB::table('teams')->insert([
            'team_name' => "Bangladesh"
        ]);
        DB::table('teams')->insert([
            'team_name' => "England"
        ]);
        DB::table('teams')->insert([
            'team_name' => "India"
        ]);
        DB::table('teams')->insert([
            'team_name' => "New Zealand"
        ]);
        DB::table('teams')->insert([
            'team_name' => "Pakistan"
        ]);
        DB::table('teams')->insert([
            'team_name' => "South Africa"
        ]);
        DB::table('teams')->insert([
            'team_name' => "Sri Lanka"
        ]);
        DB::table('teams')->insert([
            'team_name' => "Turkey"
        ]);
        DB::table('teams')->insert([
            'team_name' => "Zimbabwe"
        ]);
    }
}
