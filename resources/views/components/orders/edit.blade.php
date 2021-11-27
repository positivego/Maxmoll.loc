@extends('master')

@section('content')
    
    <div class="content">

        <h2>Редактировать заказ {{$order->id}}</h2>

        <form action="{{route('orders.update', $order)}}" method="POST">

            @method('PUT')
            @csrf

            <input type="text" name="customer" value="{{$order->customer}}" placeholder="Заказчик" autocomplete="off">

            @error('customer')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="phone" value="{{$order->phone}}" placeholder="Телефон" autocomplete="off">

            @error('phone')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="user_id">
                <option value="">Выберите менеджера</option>
                @foreach ($managers as $manager)
                    <option value="{{$manager->id}}" @if ($order->user_id === $manager->id) selected @endif>{{$manager->name}}</option>
                @endforeach
            </select>

            @error('user_id')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="type">
                <option value="">Выберите тип</option>
                <option value="online" @if ($order->type === 'online') selected @endif>online</option>
                <option value="offline" @if ($order->type === 'offline') selected @endif>offline</option>
            </select>

            @error('type')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="status">
                <option value="">Выберите статус</option>
                <option value="active" @if ($order->status === 'active') selected @endif>active</option>
                <option value="completed" @if ($order->status === 'completed') selected @endif>completed</option>
                <option value="canceled" @if ($order->status === 'canceled') selected @endif>canceled</option>
            </select>

            @error('status')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="storage">
                <option value="">Выберите склад</option>
                @foreach ($storages as $storage)
                    <option value="{{$storage->id}}" @if ($orderStorage->id === $storage->id) selected @endif>{{$storage->name}}</option>
                @endforeach
            </select>

            @error('storage')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <select name="product">
                <option value="">Выберите склад</option>
                @foreach ($orderStorage->items as $item)
                    <option value="{{$item->product_id}}" @if ($order->item->product_id === $item->product_id) selected @endif>{{$item->product->name}}</option>
                @endforeach
            </select>

            @error('product')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="stock" value="{{$order->item->count}}" placeholder="Количество" autocomplete="off">

            @error('stock')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror

            <input type="text" name="discount" value="{{$order->item->discount}}" placeholder="Скидка" autocomplete="off">

            @error('discount')
                <div class="error__item"><p>{{ $message }}</p></div>
            @enderror
            
            <button type="submit"><p>Сохранить</p></button>
        
        </form>

        <form action="" method="POST">
            
            @csrf
            @method('DELETE')

            <button type="submit"><p>Удалить</p></button>

        </form>

    </div>

@endsection