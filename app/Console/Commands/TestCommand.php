<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Str;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test user: test@email.com pass: password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $testUser = \App\User::where('email','=','test@email.com')->first();

        if($testUser){

            $email = $testUser->email;

            $testUser->delete();

            $this->info('user '.$email.' deleted');

        }
        
        $testUser = \App\User::create([
            'name' => 'Test',
            'username' => 'test',
            'email' => 'test@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        if($testUser){
            $this->info('user ' . $testUser->name . ' created');
            // $this->warn('test warn string');
        }


    }
}
