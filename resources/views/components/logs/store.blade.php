@extends('master')

@section('content')
    
    <div class="content">

        <h2>Создать тип логов</h2>

        <form action="{{ route('logs.type.store') }}" method="POST">

            @csrf

            <input type="text" name="name" value="" placeholder="Название" autocomplete="off">

            @error('name')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

    </div>

@endsection