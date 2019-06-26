<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->description = 'A Admin Role';
        $role_admin->save();

       $role_manager = new Role();
       $role_manager->name = 'Author';
       $role_manager->description = 'A Author Role';
       $role_manager->save();

        $role_user = new Role();
        $role_user->name = 'User';
        $role_user->description = 'A User Role';
        $role_user->save();
    }
}
