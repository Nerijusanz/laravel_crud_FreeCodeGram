<?php

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
        $roles = $this->userRoles();

        foreach($roles as $role){

            \App\Role::create(['name'=>$role]);

        }


    }

    private function userRoles(){

        return ['show_user','add_user','edit_user','update_user','delete_user'];

    }
}
