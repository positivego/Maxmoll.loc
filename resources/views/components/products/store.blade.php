@extends('master')

@section('content')
    
    <div class="content">

        <h2>Создать продукт</h2>

        <form action="{{ route('products.store') }}" method="POST">

            @csrf

            <input type="text" name="name" value="" placeholder="Наименование" autocomplete="off">

            @error('name')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="price" value="" placeholder="Цена" autocomplete="off">

            @error('price')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="stock" value="" placeholder="Количество" autocomplete="off">
            
            @error('stock')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
    
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

    </div>

@endsection