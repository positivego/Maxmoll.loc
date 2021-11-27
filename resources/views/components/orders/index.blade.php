@extends('master')

@section('content')
    
    <div class="content">

        <h2>Заказы</h2>

        <div class="history">

            <form action="{{route('orders.get.history')}}" method="POST">

                @csrf
    
                <input type="date" name="date">
        
                <button type="submit"><p>Найти заказы за период</p></button>
            
            </form>

        </div>

        <table>

            <thead>
                <tr>
                    <th class="non-border-left"><div class="line"></div><p>Заказчик</p></th>
                    <th><p>Телефон</p></th>
                    <th><p>Создан</p></th>
                    <th><p>Завершен</p></th>
                    <th><p>Менеджер</p></th>
                    <th><p>Тип</p></th>
                    <th class="non-border-right"><p>Статус</p></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($orders as $order)
                    <tr>
                        <td class="non-border-left"><div class="line"></div><a href="{{route('orders.edit', $order)}}">{{$order->customer}}</a></td>
                        <td class=""><p>{{$order->phone}}</p></td>
                        <td class=""><p>{{$order->created_at}}</p></td>
                        <td class=""><p>{{$order->completed_at}}</p></td>
                        <td class=""><p>{{$order->user->name}}</p></td>
                        <td class=""><p>{{$order->type}}</p></td>
                        <td class="non-border-right"><p>{{$order->status}}</p></td>
                    </tr>
                @endforeach

                <td colspan="5" class="non-border-left non-border-right">
                    <div class="line"></div>
                    <a href="{{route('orders.create')}}">Создать</a>
                    <div class="line"></div>
                </td>
            </tbody>

        </table>

    </div>

@endsection