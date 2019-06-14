@extends('layouts.app')


@section('content')
<h1>Posts</h1>
@if(count($posts) > 0)
    @foreach($posts as $post)
        
            <div class="row mb-5">
                @if($post->image != null)
                    <div class="col-md-4 col-sm-4">

                        <img style="width:100%" src="/storage/images/{{$post->image}}" />

                    </div>
                @endif
                <div class="col-md-8 col-sm-8">
                    <h3>
                    <a href="/posts/{{$post->id}}">{{$post->caption}}</a>
                    </h3>
                    <small>published on {{$post->created_at}} by {{$post->user->username}}</small>
                </div>
            </div>
        
    @endforeach

@endif

    <div class="row">

        @if(count($posts) > 0)
            
            <div class="col-md-12 col-sm-12 d-flex justify-content-center">
                {{$posts->links()}}
            </div>
            
        @else
            
            <div class="col-md-4 col-sm-4 d-flex justify-content-start">
                <p>no posts...</p>
            </div>
            
        @endif
    </div>

@endsection
