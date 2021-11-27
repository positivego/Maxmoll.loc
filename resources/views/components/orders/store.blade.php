@extends('master')

@section('content')
    
    <div class="content">

        <h2>Создать заказ</h2>

        <form action="{{route('orders.store')}}" method="POST">

            @csrf

            <input type="text" name="customer" value="" placeholder="Заказчик" autocomplete="off">

            @error('customer')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="phone" value="" placeholder="Телефон" autocomplete="off">

            @error('phone')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="user_id">
                <option value="">Выберите менеджера</option>
                @foreach ($managers as $manager)
                    <option value="{{$manager->id}}">{{$manager->name}}</option>
                @endforeach
            </select>

            @error('user_id')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="type">
                <option value="">Выберите тип</option>
                <option value="online">online</option>
                <option value="offline">offline</option>
            </select>

            @error('type')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="status">
                <option value="">Выберите статус</option>
                <option value="active">active</option>
                <option value="completed">completed</option>
                <option value="canceled">canceled</option>
            </select>

            @error('status')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="storage">
                <option value="">Выберите склад</option>
                @foreach ($storages as $storage)
                    <option value="{{$storage->id}}">{{$storage->name}}</option>
                @endforeach
            </select>

            @error('storage')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            @error('stock')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
            
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

    </div>

@endsection