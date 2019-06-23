<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

//use \Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{

    use RefreshDatabase;

    //IMPORTANT NOTE:
    //function name should started with prefix `testYourFuncName()`


    public function testNotLoggedInUserDoNotSeeProfilesPage(){

        $response = $this->get('/profiles')->assertStatus(302); //user not  logged in
 
    }

    public function testNotLoggedInUserDoNotSeeProfilesPageAndRedirectedToLoginPage()   
    {
        $response = $this->get('/profiles')
            ->assertRedirect('/login'); //not loged in user end in login page

    }

    public function testLoggedInUserCanSeeProfilesPage(){

        $this->actingAs(factory(\App\User::class)->create() ); //created user and logged in

        $response = $this->get('/profiles')
            ->assertOk();

    }



}

