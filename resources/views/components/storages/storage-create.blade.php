@extends('master')

@section('content')
    
    <div class="content">

        <h2>Добавить продукт в {{$storage->name}} </h2>

        <form action="{{ route('storages.storage.add', $storage) }}" method="POST">

            @csrf

            <select name="product_id">
                @foreach ($products as $product)
                    <option value="{{$product->id}}">{{$product->name}} - На складе {{$product->stock}}</option>
                @endforeach
            </select>

            @error('product_id')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="stock" value="" placeholder="Количество" autocomplete="off">

            @error('stock')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Добавить</p></button>
        
        </form>

    </div>

@endsection