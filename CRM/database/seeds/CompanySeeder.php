<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'local') //development
        {
            $faker = Faker\Factory::create();
            for ($i = 0; $i < 5; $i++) {
                DB::table('companies')->insert([
                    'short_name'    => $faker->company,
                    'official_name' => 'ТОО '.$faker->company,
                ]);
            }
            $this->call(OfficeSeeder::class);
        }


    }
}
