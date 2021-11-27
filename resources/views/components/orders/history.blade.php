@extends('master')

@section('content')
    
    <div class="content">

        <h2>Заказы за выбранный период</h2>

        <table>

            <thead>
                <tr>
                    <th class="non-border-left"><div class="line"></div><p>Заказчик</p></th>
                    <th><p>Телефон</p></th>
                    <th><p>Создан</p></th>
                    <th><p>Завершен</p></th>
                    <th><p>Менеджер</p></th>
                    <th><p>Тип</p></th>
                    <th><p>Сумма</p></th>
                    <th class="non-border-right"><p>Статус</p></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($orders as $order)
                    <tr>
                        <td class="non-border-left"><div class="line"></div><a href="{{route('orders.edit', $order)}}">{{$order->customer}}</a><div class="line"></div></td>
                        <td class=""><p>{{$order->phone}}</p></td>
                        <td class=""><p>{{$order->created_at}}</p></td>
                        <td class=""><p>{{$order->completed_at}}</p></td>
                        <td class=""><p>{{$order->user->name}}</p></td>
                        <td class=""><p>{{$order->type}}</p></td>
                        <td class=""><p>{{$order->item->cost}}</p></td>
                        <td class="non-border-right"><p>{{$order->status}}</p></td>
                    </tr>
                @endforeach

                <td colspan="5" class="non-border-left non-border-right">
                    <div class="line"></div>
                    <p>Всего заказов <strong style="color: red;">{{count($orders)}}</strong> на сумму <strong style="color: red;">{{$cost}}</strong></p>
                    <div class="line"></div>
                </td>

            </tbody>

        </table>

    </div>

@endsection