@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Create Post</h1>

    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        

        <div class="form-group">
            {{Form::label('caption', 'Caption')}}
                <?php $itemClass = $errors->has('caption')? 'form-control is-invalid' : 'form-control'; ?>
                {{Form::text('caption', '', ['class' => $itemClass, 'placeholder' => 'Caption'])}}
            
            @error('caption')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <?php $itemClass = $errors->has('image')? 'is-invalid' : ''; ?>
            {{Form::file('image',['class'=>$itemClass])}}
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        {{Form::submit('Create', ['class'=>'btn btn-primary'])}}

    {!! Form::close() !!}


@endsection