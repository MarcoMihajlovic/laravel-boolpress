@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{$category -> name}}</h1>
                <ul>
                    @foreach ($category->posts as $post)
                        <li>
                            <a href="{{route('post', ['slug' => $post -> slug])}}">{{$post->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection