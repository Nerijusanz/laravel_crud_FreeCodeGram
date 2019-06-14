<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\User;

class ProfilesController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */

    public static $paginate = 5;


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $userId = auth()->user()->id;

        

        $user = User::findOrFail($userId);

        $userPosts = $user->posts()
            ->orderBy('created_at','DESC')
            ->paginate(self::$paginate);

        $cacheCountPosts = Cache::remember(
            'count.posts.userid='.$user->id,
            now()->addSeconds(30),  //addDay,addWeek,addMonth...
            function() use ($user){ //use($user)  attach variable $user to function 
                return $user->posts->count();
            }
        );



        $data = [
            'posts'=>$userPosts,
            'countPosts'=>$user->posts()->count()
        ];

        return view('/profiles/index')->with('data',$data);


    }
}
