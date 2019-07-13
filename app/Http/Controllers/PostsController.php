<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use \App\User;
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

        //Policy user : UserPolicy@create
        $this->authorize('create',User::class);

        return view('/posts/create');
    }

    public function store(Request $request){

        //dd(request()->all());
        
        //Policy user: UserPolicy@create
        $this->authorize('create',User::class);

        $data = $this->validateRequestData();

        $post = new Post;
        $post->user_id = auth()->user()->id;    //authenticated user
        $post->caption = $data['caption'];  // get validate caption


        if(request()->hasFile('image')){
            
            // Upload Image
            $requestFileObj = request()->file('image');
            $fileNameToStore = $this->fileNameToStore( $requestFileObj );

            $this->uploadImage($requestFileObj,$fileNameToStore,$oldUploadedFile=null );
            
            $post->image = $fileNameToStore;
        }

        $post->save();
        return redirect('profiles')->with('success','Post Created');

    }

    public function edit(User $user,$id)
    {
        $this->authorize('update',$user);
        
        if(!isset($id)){
            return redirect('/posts')->with('error','post not founded');
        }

        $post = Post::findOrFail($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','unauthorized page');
        }

        return view('posts.edit')->with('post',$post);

    }

    public function update(Request $request,User $user,$id)
    {

        //dd(request()->all());

        $this->authorize('update',$user);

        $data  = $this->validateRequestData();

        $post = Post::find($id);
        $post->caption = $data['caption'];

        if(request()->hasFile('image')){
            
            // Upload Image
            $requestFileObj = request()->file('image');
            $fileNameToStore = $this->fileNameToStore( $requestFileObj );
            $oldUploadedFile = $post->image;
            $this->uploadImage($requestFileObj,$fileNameToStore,$oldUploadedFile );
            
            $post->image = $fileNameToStore;
        }
        
        $post->save();
        return redirect('/profiles')->with('success','item updated');

    }

    public function destroy(User $user,$id)
    {

        $this->authorize('delete',$user);

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

    private function validateRequestData(){


        $data = request()->validate([
            'caption'=>['required', 'string','min:3', 'max:255']
        ]);

        if(request()->hasFile('image')){

            $file = request()->validate([
                'image' => 'file|image|max:1999'
            ]);

            $data = array_merge($data,$file);
        }

        return $data;

    }


    protected function fileNameToStore( $requestFileObj ){

        if($requestFileObj === null) return null;

            // Get filename with the extension
            $filenameWithExt = $requestFileObj->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $requestFileObj->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;

            return $fileNameToStore;

    }


    protected function uploadImage($requestFileObj,$fileNameToStore,$oldFileWasUploaded=null){

        if($requestFileObj === null ) return false;

            // if file was uploaded before
            if($oldFileWasUploaded !== null){
                // Delete Image from storage
                Storage::delete('public/images/' . $oldFileWasUploaded);
            }

            // Request() Upload File
            $requestFileObj->storeAs('public/images', $fileNameToStore );

            //Intervention Image library, php open source library
            //processing image dimensions
            $image = Image::make(public_path('storage/images/' . $fileNameToStore ))->fit(300,300);
            $image->save();

    }
}