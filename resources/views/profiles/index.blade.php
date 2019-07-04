@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
            
    @if(Auth::user())
        <div class="row">
            <div class="col-md-8 col-sm-8 mb-2">     
                <a href="/posts/create" class="btn btn-primary">

                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                    Create Post</a>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 col-sm-12 mb-2">     
            <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Caption</th>
                        <th scope="col" class="text-right">Edit</th>
                        <th scope="col" class="text-right">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
        
            @if(count($data['posts']) > 0)
                <?php $i=1;?>
                @foreach($data['posts'] as $post)
                    
                    <tr>
                        <td><?= $i;?></td>
                        <td>
                            @if($post['image'] != null)
                                <img style="width:25px; height: 25px;" src="/storage/images/{{$post['image']}}" />
                            @else
                                <img style="width:25px; height: 25px;" src="/storage/images/no_image.png" />
                            @endif
                        </td>
                        <td>
                            <a href="/posts/{{$post['id']}}">{{$post['caption']}}</a></td>                   
                        <td class="text-right">
                            @if(Auth::user()->can('update',Auth::user()))
                                <a class="btn btn-default " href="/posts/{{$post['id']}}/edit"><i class="fa fa-edit"></i></a>
                            @endif
                        </td>
                        <td>
                            @if(Auth::user()->can('delete',Auth::user()))
                                {!!Form::open(['action' => ['PostsController@destroy', $post['id'] ], 'method' => 'POST', 'class' => 'text-right'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit','onclick'=>"return confirm('Are you sure you want to delete this item?');",'class' => 'btn btn-danger btn-sm'] )  }}
                                {!!Form::close()!!}
                            @endif
    
                        </td>
                    </tr>
                    <?php $i++;?>
                @endforeach
                    
            @endif
        
            </tbody>
            </table>

            <div class="row">

                <div class="col-md-12 col-sm-12 d-flex justify-content-start">
                    <p><span class="font-weight-bold">Total posts:</span> <span>{{$data['countPosts']}}</span></p>
                </div>

                @if(count($data['posts']) > 0)
                    
                    <div class="col-md-12 col-sm-12 d-flex justify-content-center">
                        {{$data['posts']->links()}}
                    </div>
                    
                @else
                    
                    <div class="col-md-4 col-sm-4 d-flex justify-content-start">
                        <p>no posts...</p>
                    </div>
                    
                @endif
            </div>

        </div>
    </div>



</div>
@endsection

