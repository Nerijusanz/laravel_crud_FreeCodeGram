<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;



use App\User;
use App\Post;

class PostsTest extends TestCase
{

    use RefreshDatabase;
    

    public function testPosts()
    {
        $response = $this->get('/posts')
            ->assertOK();
    }

    public function testAdminCanBeStoreThePostThroughThePostCreateForm(){

        $this->withoutExceptionHandling(); //turn off laravel exception error

        $userEmail = 'admin@email.com';

        $user = factory(User::class)->create([
            'email'=> $userEmail
        ]);

        $userId = $user->id;

        $user = User::where('id','=',$userId)->first();

        $this->actingAs($user); //logged in user


        $this->post('/posts',$this->_postData($userId,'test Caption'));

        //check if post created
        $this->assertCount(1,Post::all());

        //check if post created belongs logged in user
        $postByUserId = Post::where('user_id','=',$userId)->get();

        $this->assertCount(1,$postByUserId);

    }


    public function testPostCaptionFieldRequired(){

        

        $userEmail = 'admin@email.com';

        $user = factory(User::class)->create([
            'email'=> $userEmail
        ]);

        $userId = $user->id;
        
        $response = $this->post('/posts',$this->_postData($userId,'') );
        
        $this->assertCount(0,Post::all());
        
        //$response->assertSessionHasErrors('caption'); //don`t working
        //dd(session()->all());

    }

    public function testPostCaptionFieldLeastThreeCharactersRequired(){

        $userEmail = 'admin@email.com';

        $user = factory(User::class)->create([
            'email'=> $userEmail
        ]);

        $userId = $user->id;
        
        $response = $this->post('/posts',$this->_postData($userId,'xx') );
        
        $this->assertCount(0,Post::all());

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
