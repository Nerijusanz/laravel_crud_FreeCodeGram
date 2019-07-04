<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($id){

        $user = User::find($id);

        if(!$user) return null;

        $ajaxResponse = [
            'id'=>$user->id,
            'username'=>$user->username
        ];

        return $ajaxResponse;
    }
}
