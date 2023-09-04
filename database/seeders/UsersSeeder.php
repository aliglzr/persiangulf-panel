<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
//        $demoUser = User::create([
//            'first_name'        => $faker->firstName,
//            'last_name'         => $faker->lastName,
//            'email'             => 'demo@demo.com',
//            'username'          => 'demo',
//            'password'          => Hash::make('demo'),
//            'api_token'         => Hash::make('demo@demo'),
//        ]);

        $psycho = User::create([
            'first_name' => 'Psycho',
            'last_name' => 'Parades',
            'username' => 'psycho',
            'uuid' => uuid_create(),
            'email' => 'pyscho@solidvpn.org',
            'email_verified_at' => now(),
            'password' => Hash::make('jhtfhdgks')
        ]);
        $tokyo = User::create([
            'first_name' => 'Tokyo',
            'last_name' => 'Hernandez',
            'username' => 'tokyo',
            'uuid' => uuid_create(),
            'email' => 'tokyo@solidvpn.org',
            'email_verified_at' => now(),
            'password' => Hash::make('jhtfhdgks')
        ]);
        $sherlock = User::create([
            'first_name' => 'Sherlock',
            'last_name' => 'Holmes',
            'username' => 'sherlock',
            'uuid' => uuid_create(),
            'email' => 'sherlock@solidvpn.org',
            'email_verified_at' => now(),
            'password' => Hash::make('jhtfhdgks')
        ]);
        $solidvpn = User::create([
            'first_name' => 'SolidVPN',
            'last_name' => 'Sales',
            'username' => 'solidvpn_sales',
            'uuid' => uuid_create(),
            'email' => 'sale@solidvpn.org',
            'email_verified_at' => now(),
            'password' => Hash::make('jhtfhdgks')
        ]);
        $solidvpn->save();

        $solidvpn->assignRole('agent');
        $tokyo->assignRole('manager');
        $pyscho->assignRole('manager');
        $sherlock->assignRole('manager');


    }
}
