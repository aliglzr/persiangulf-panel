<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call([
            CountrySeeder::class,
            CategorySeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            PermissionsSeeder::class,
            SyncRolesWithPermissionsSeeder::class,
        ]);
    }
}
