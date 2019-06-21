@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Edit Post</h1>

    <div class="row">
        <div class="col-md-12 col-sm-12 mb-5">
            <a href="/posts/{{$post->id}}" class="btn btn-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i> back</a>
        </div>
    </div>

    <div class="row">
 
        <div class="col-md-12 col-sm-12 d-flex justify-content-center">
        
            {!! Form::open(['action' => ['PostsController@update', 'id'=>$post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                <div class="col-md-12 col-sm-12 mb-5">
                    {{Form::label('caption', 'Caption')}}
                    {{Form::text('caption', $post->caption, ['class' => 'form-control', 'placeholder' => 'Caption'])}}
                
                    @if($post->image != null)
                        <div class="col-md-3 col-sm-3 mb-5">
                            <p>{{$post->image}}</p>
                            <img style="width:100%" src="/storage/images/{{$post->image}}" />
                        </div>
                    @endif

                    <div class="col-md-12 col-sm-12 mb-5">
                        <div class="form-group">
                            {{Form::file('image')}}
                        </div>
                    </div>
                </div>
                {{Form::hidden('_method','PUT')}}
                {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}

        </div>
    </div>
@endsection