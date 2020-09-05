<?php

use Illuminate\Database\Seeder;
// use DB;
class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_string = File::get('public/movies.json');
        $decoded= json_decode($json_string);
        foreach ($decoded as $data){
            DB::table('movies')->insert([
                'id' => $data->id,
                'title' => $data->title,
                'release_date' => $data->release_date,
                'duration' => $data->duration,
                'genre' => $data->genre
            ]);
        }
    }
}
