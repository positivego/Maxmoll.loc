@extends('master')

@section('content')
    
    <div class="content">

        <h2>Редактировать {{$user->name}}</h2>

        <form action="{{ route('users.update', $user) }}" method="POST">

            @method('PUT')
            @csrf

            <input type="text" name="name" value="{{$user->name}}" placeholder="Имя пользователя" autocomplete="off">

            @error('name')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

        <form action="{{ route('users.destroy', $user) }}" method="POST">
            
            @csrf
            @method('DELETE')

            <button type="submit"><p>Удалить</p></button>

        </form>

    </div>

@endsection