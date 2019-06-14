<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{

    public static $paginate=3;

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]); //not needed loged in
    }


    public function index(){

        $posts = Post::orderBy('created_at','DESC')
                ->paginate(self::$paginate);

        return view('posts.index')->with('posts',$posts);

    }

    public function show($id){

        if(!isset($id)){
            return redirect('/posts')->with('error','post not founded');
        }

        $post = Post::findOrFail($id);

        return view('posts.show')->with('post',$post);

    }

    public function create(){
        return view('/posts/create');
    }

    public function store(Request $request){

        //dd(request()->all());

        $this->validate($request,[
            'caption'=>['required', 'string', 'max:255'],
            'image' => 'image|nullable|max:1999'
        ]);

        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->caption = $request->input('caption');

        if($request->hasFile('image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);

            //save uploaded file to posts DB
            $post->image = $fileNameToStore;
        }

        $post->save();
        return redirect('profiles')->with('success','Post Created');

    }

    public function edit($id)
    {
        
        if(!isset($id)){
            return redirect('/posts')->with('error','post not founded');
        }

        $post = Post::findOrFail($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','unauthorized page');
        }

        return view('posts.edit')->with('post',$post);

    }

    public function update(Request $request,$id)
    {

        //dd(request()->all());

        $this->validate($request,[
            'caption'=>['required', 'string', 'max:255'],
            'image' => 'image|nullable|max:1999'
        ]);

        $post = Post::find($id);
        $post->caption = $request->input('caption');

        if($request->hasFile('image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;

            // if file was uploaded before
            if($post->image){
                // Delete Image from storage
                Storage::delete('public/images/'.$post->image);
            }
            
            // Upload Image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);

            //save uploaded file to posts DB
            $post->image = $fileNameToStore;
        }

        $post->save();
        return redirect('/profiles')->with('success','Post Created');

    }

    public function destroy($id)
    {

        $post = Post::findOrFail($id);

        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/profiles')->with('error', 'No Post Found');
        }
        /*
        
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        */

        //if file uploaded
        if($post->image){
            // Delete Image
            Storage::delete('public/images/'.$post->image);
        }

        $post->delete();

        return redirect('/profiles')->with('success', 'Post Removed');

    }
}
