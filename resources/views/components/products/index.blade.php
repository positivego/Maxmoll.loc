@extends('master')

@section('content')
    
    <div class="content">

        <h2>Продукты</h2>

        <table>

            <thead>
                <tr>
                    <th class="non-border-left"><div class="line"></div><p>Наименование</p></th>
                    <th><p>Цена</p></th>
                    <th class="non-border-right"><p>Количество</p></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($products as $product)
                    <tr>
                        <td class="non-border-left"><div class="line"></div><a href="{{route('products.edit', $product->id)}}">{{$product->name}}</a></td>
                        <td class=""><p>{{$product->price}}</p></td>
                        <td class="non-border-right"><p>{{$product->stock}}</p></td>
                    </tr>
                @endforeach

                <td colspan="5" class="non-border-left non-border-right">
                    <div class="line"></div>
                    <a href="{{route('products.create')}}">Создать</a>
                    <div class="line"></div>
                </td>
            </tbody>

        </table>

    </div>

@endsection