@extends('master')

@section('content')
    
    <div class="content">

        <h2>Типы логов</h2>

        <table>

            <thead>
                <tr>
                    <th class="non-border-left"><div class="line"></div><p>Имя</p></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($types as $type)
                    <tr>
                        <td class="non-border-left""><div class="line"></div><a href="{{route('logs.type.edit', $type->id)}}">{{$type->name}}</a></td>
                    </tr>
                @endforeach

                <td colspan="5" class="non-border-left non-border-right">
                    <div class="line"></div>
                    <a href="{{route('logs.type.create')}}">Создать</a>
                    <div class="line"></div>
                </td>
            </tbody>

        </table>

    </div>

@endsection