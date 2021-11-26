@extends('master')

@section('content')
    
    <div class="content">

        <h2>Редактировать {{$storage->name}}</h2>

        <form action="{{ route('storages.update', $storage) }}" method="POST">

            @method('PUT')
            @csrf

            <input type="text" name="name" value="{{$storage->name}}" placeholder="Наименование" autocomplete="off">

            @error('name')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

        <form action="{{ route('storages.destroy', $storage) }}" method="POST">
            
            @csrf
            @method('DELETE')

            <button type="submit"><p>Удалить</p></button>

        </form>

    </div>

@endsection