<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $policyUsers = $this->policyUsers();

        foreach($policyUsers as $user){

            \App\User::create($user);

        }
    
    }

    private function policyUsers(){

        return Array(
            [
                'name' => sprintf('%s','Admin'),
                'username' => sprintf('%s','admin'),
                'email' => 'admin@email.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => sprintf('%s','Guest'),
                'username' => sprintf('%s','guest'),
                'email' => 'guest@email.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => sprintf('%s','Administrator'),
                'username' => sprintf('%s','administrator'),
                'email' => 'administrator@email.com',
                'password' => bcrypt('password')
            ]
        );

    }

    
}
