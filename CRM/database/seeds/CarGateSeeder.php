<?php

use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CarGateSeeder extends Seeder
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

            for ($i = 0; $i < 20; $i++) {
                try {
                    DB::table('car_gate')->insert([
                        'has_access' => $faker->boolean,
                        'gate_id'    => rand(1, 10),
                        'car_id'     => $i + 1,
                    ]);
                } catch (Exception $exception) {
                    continue;
                }

            }
            Car::find(21)->gates()->attach(6, ['has_access' => true]);
            $this->call(CarEnterSeeder::class);

        }


    }
}
