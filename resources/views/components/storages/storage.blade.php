@extends('master')

@section('content')
    
    <div class="content">

        <h2>Список продуктов в {{$storage->name}}</h2>

        <div class="history"><a href="{{route('storages.storage.history', $storage)}}">Лог склада</a></div>

        <table>

            <thead>
                <tr>
                    <th class="non-border-left"><div class="line"></div><p>Наименование</p></th>
                    <th><p>Цена</p></th>
                    <th><p>На складе</p></th>
                    <th class="non-border-right"><p>В остатке</p></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($storage->items as $item)
                    <tr>
                        <td class="non-border-left"><div class="line"></div><a href="{{route('storages.storage.move.product', [$storage, $item])}}">{{$item->product->name}}</a></td>
                        <td><p>{{$item->product->price}}</p></td>
                        <td><p>{{$item->stock}}</p></td>
                        <td class="non-border-right"><p>{{$item->product->stock}}</p></td>
                        <td class="non-border-left non-border-right"><a href="{{route('storages.storage.product.history', [$storage, $item->product])}}">Лог продукта</a></td>
                    </tr>
                @endforeach

                <td colspan="5" class="non-border-left non-border-right">
                    <div class="line"></div>
                    <a href="{{route('storages.storage.product', $storage)}}">Добавить</a>
                    <div class="line"></div>
                </td>
            </tbody>

        </table>

    </div>

@endsection