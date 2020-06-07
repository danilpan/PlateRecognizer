<?php

use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CarEnterSeeder extends Seeder
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
            $cars  = Car::all();

            foreach ($cars as $car) {
                try {
                    $gates  = $car->getGateIds();
                    $gateId = $faker->randomElement($gates);
                    DB::table('cars_enters')->insert([
                        'has_entered' => $car->hasAccessToGate($gateId),
                        'gate_id'     => $gateId,
                        'car_id'      => $car->id,
                    ]);
                } catch (TypeError $exception) {
                    continue;
                }
            }

        }


    }
}
