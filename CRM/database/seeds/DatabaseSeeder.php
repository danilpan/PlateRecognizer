<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
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
            // Admin
            DB::table('users')->insert([
                'email'    => 'admin@npr.kz',
                'name'     => 'Admin',
                'password' => Hash::make('1234567890'),
            ]);
            $this->call(CompanySeeder::class);
        }


    }
}
