@extends('master')

@section('content')
    
    <div class="content">

        <h2>Редактировать {{$product->name}}</h2>

        <form action="{{ route('products.update', $product) }}" method="POST">

            @method('PUT')
            @csrf

            <input type="text" name="name" value="{{$product->name}}" placeholder="Наименование" autocomplete="off">

            @error('name')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="price" value="{{$product->price}}" placeholder="Цена" autocomplete="off">

            @error('price')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="stock" value="{{$product->stock}}" placeholder="Количество" autocomplete="off">
            
            @error('stock')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

        <form action="{{ route('products.destroy', $product) }}" method="POST">
            
            @csrf
            @method('DELETE')

            <button type="submit"><p>Удалить</p></button>

        </form>

    </div>

@endsection