@extends('master')

@section('content')
    
    <div class="content">

        <h2>Переместить продукт {{$item->product->name}} из {{$storage->name}}</h2>

        <form action="{{ route('storages.storage.move', [$storage, $item]) }}" method="POST">

            @csrf

            <select name="storage_id">
                @foreach ($storages as $el)
                    @if ($el->id !== $storage->id)
                        <option value="{{$el->id}}">На {{$el->name}}</option>
                    @endif
                @endforeach
            </select>

            @error('storage_id')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="stock" value="" placeholder="Количество" autocomplete="off">

            @error('stock')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Переместить</p></button>
        
        </form>

    </div>

@endsection