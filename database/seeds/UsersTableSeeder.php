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
        //Random Factorie seeder command
        // factory(\App\User::class,5)->create();

        //DB::table('users')->delete();

        //run command:
        // php artisan db:seed
        //php artisan db:seed --class=UsersTableSeeder
        
        $users_num = 3;
        $i=1;
        

        while($i<=$users_num){

            $user = Array(
                'name' => sprintf('User%s',$i),
                'username' => sprintf('user%s',$i),
                'email' => sprintf('user%s@email.com',$i),
                'password' => bcrypt('password')
            );

            $user = \App\User::create($user);
        
            //create user Profile by user
            $profile = Array(
                'user_id'=>$user['id'],
                'title'=>sprintf('Panel title: %s',$user['username']),
                'description'=>sprintf('panel description: %s',$user['username'])
            );

            //$profile = \App\Profile::create($profile);
            DB::table('profiles')->insert($profile);
            

            $i++;
        }

        $policyUsers = Array(
            [
                'name' => sprintf('User %s','Admin'),
                'username' => sprintf('%s','adminuser'),
                'email' => 'admin@email.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => sprintf('User %s','Guest'),
                'username' => sprintf('%s','guestuser'),
                'email' => 'guest@email.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => sprintf('User %s','Administrator'),
                'username' => sprintf('%s','administrator'),
                'email' => 'administrator@email.com',
                'password' => bcrypt('password')
            ]
        );

        foreach($policyUsers as $p_user){

            \App\User::create($p_user);

        }

        
    }
}
