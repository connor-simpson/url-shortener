<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dictionary;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dictionary::truncate();
        $file = fopen(resource_path("txt/words.txt"), "r");
        while(!feof($file)) {
            $array = preg_split('/\s+/', fgets($file));
            if(isset($array[1])){
                Dictionary::create([
                    "word" => $array[1]
                ]);
            }
        }

        fclose($file);
    }
}
