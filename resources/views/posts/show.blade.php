@extends('layouts.app')

@section('content')

    <div class="row">

        @if(Auth::user())
            @if(Auth::user()->id == $post->user_id )

                <div class="col-md-12 col-sm-12">
                    <a href="/profiles" class="btn btn-primary mb-5"><i class="fa fa-angle-double-left" aria-hidden="true"></i> back</a>
                </div>
        
                <div class="col-md-12 col-sm-12">
                    
                    <div class="pull-right">

                        @if(Auth::user()->can('delete',Auth::user()))
                            <div class="btn-group" role="group" aria-label="edit-post">
                                <a href="/posts/{{$post->id}}/edit" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'text-right'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit','onclick'=>"return confirm('Are you sure you want to delete this item?');",'class' => 'btn btn-danger btn-sm'] )  }}
                                {!!Form::close()!!}
                            </div>
                        @endif

                    </div>
                </div>

            @endif
        @endif

        <div class="col-md-12 col-sm-12">
            <div class="d-flex">
            <h1>{{$post->caption}}</h1>
            @if(Auth::user())
                <follow-button user-id="{{Auth::user()->id}}"></follow-button>
            @endif
            </div>

            <small>published on {{$post->created_at}} by {{$post->user->name}}</small>
            <hr>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-4 col-sm-4">
                @if($post->image != null)
                    <img style="width:100%" src="/storage/images/{{$post->image}}" />
                @else
                    <img style="width:100%" src="/storage/images/no_image.png" />
                @endif
                
            </div>
            
        </div>

    </div>

@endsection