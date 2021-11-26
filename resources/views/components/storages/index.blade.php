@extends('master')

@section('content')
    
    <div class="content">

        <h2>Склады</h2>

        <div class="cards">
            @foreach ($storages as $storage)
                <div class="card">
                    <a href="{{route('storages.storage', $storage)}}">{{$storage->name}}</a>
                </div>
            @endforeach
        </div>

    </div>

@endsection