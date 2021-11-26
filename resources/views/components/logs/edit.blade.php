@extends('master')

@section('content')
    
    <div class="content">

        <h2>Редактировать {{$type->name}}</h2>

        <form action="{{ route('logs.type.update', $type) }}" method="POST">

            @method('PUT')
            @csrf

            <input type="text" name="name" value="{{$type->name}}" placeholder="Наименование" autocomplete="off">

            @error('name')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

        <form action="{{ route('logs.type.destroy', $type) }}" method="POST">
            
            @csrf
            @method('DELETE')

            <button type="submit"><p>Удалить</p></button>

        </form>

    </div>

@endsection