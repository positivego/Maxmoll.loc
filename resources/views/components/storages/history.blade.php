@extends('master')

@section('content')
    
    <div class="content">

        <h2>История перемещений {{$storage->name}}</h2>

        <table>

            <thead>
                <tr>
                    <th class="non-border-left"><div class="line"></div><p>Откуда</p></th>
                    <th><p>Куда</p></th>
                    <th><p>Тип</p></th>
                    <th><p>Продукт</p></th>
                    <th class="non-border-right"><p>Количество</p></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($logs as $log)
                    <tr>
                        <td class="non-border-left"><div class="line"></div><p>@if ($log->from === null) @else {{$log->from->name}} @endif</p><div class="line"></div></td>
                        <td class=""><p>@if ($log->to === null) @else {{$log->to->name}} @endif</p></td>
                        <td class=""><p>{{$log->type->name}}</p></td>
                        <td class=""><p>{{$log->product->name}}</p></td>
                        <td class="non-border-right"><p>{{$log->stock}}</p></td>
                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

@endsection