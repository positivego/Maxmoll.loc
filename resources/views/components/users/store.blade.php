@extends('master')

@section('content')
    
    <div class="content">

        <h2>Создать пользователя</h2>

        <form action="{{ route('users.store') }}" method="POST">

            @csrf

            <input type="text" name="name" value="" placeholder="Имя пользователя" autocomplete="off">

            @error('name')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

    </div>

@endsection