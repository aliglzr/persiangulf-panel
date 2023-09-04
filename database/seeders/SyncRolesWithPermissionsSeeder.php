<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SyncRolesWithPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientRole = Role::where('name','client')->first();
        $agentRole = Role::where('name','agent')->first();
        $supportRole = Role::where('name','support')->first();

        $agentRole->givePermissionTo(['deactivate-client','delete-client']);
    }
}
