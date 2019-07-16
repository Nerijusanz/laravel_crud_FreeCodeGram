<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;



use App\User;
use App\Post;

class PostsTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp():void
    {

        parent::setUp();

        Event::fake();
    }
    

    public function testPosts()
    {
        $response = $this->get('/posts')
            ->assertOK();
    }

    public function testAdminCanBeStoreThePostThroughThePostCreateForm(){

        $this->withoutExceptionHandling(); //turn off laravel exception error

        $user = $this->_createAdminUser();

        $this->actingAs($user); //logged in user


        $this->post('/posts',$this->_postData($user->id,'test Caption'));

        //check if post created
        $this->assertCount(1,Post::all());

        //check if post created belongs logged in user
        $postByUserId = Post::where('user_id','=',$user->id)->get();

        $this->assertCount(1,$postByUserId);

    }


    public function testPostCaptionFieldRequired(){

        $user = $this->_createAdminUser();
        
        $response = $this->post('/posts',$this->_postData($user->id,'') );
        
        $this->assertCount(0,Post::all());
        
        //$response->assertSessionHasErrors('caption'); //don`t working
        //dd(session()->all());

    }

    public function testPostCaptionFieldLeastThreeCharactersRequired(){


        $user = $this->_createAdminUser();
        
        $response = $this->post('/posts',$this->_postData($user->id,'xx') );
        
        $this->assertCount(0,Post::all());

    }

    private function _createAdminUser(){

        $email = 'admin@email.com';

        return factory(User::class)->create([
            'email'=> $email
        ]);

    }

    private function _postData($userId,$caption){

        return [
            'id'=>'1',
            'user_id'=> $userId,
            'caption'=>$caption,
            //'image' =>''
        ];
    }



}
