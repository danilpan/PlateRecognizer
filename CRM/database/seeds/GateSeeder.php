<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GateSeeder extends Seeder
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
                DB::table('gates')->insert([
                    'name'        => $faker->streetName,
                    'office_id'   => $i + 1,
                    'client_hash' => md5($faker->macAddress),
                ]);
            }

            DB::table('gates')->insert([
                'name'        => $faker->streetName,
                'office_id'   => 1,
                'client_hash' => '53c626118b567a8c44aaefb3be40c018',
            ]);
            $this->call(CarSeeder::class);
        }
    }
}
