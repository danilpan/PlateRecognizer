<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OfficeSeeder extends Seeder
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
                DB::table('offices')->insert([
                    'full_address' => $faker->address,
                    'company_id'   => $i + 1,
                ]);
            }
            $this->call(GateSeeder::class);
        }


    }
}
