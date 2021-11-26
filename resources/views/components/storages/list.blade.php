@extends('master')

@section('content')
    
    <div class="content">

        <h2>Склады</h2>

        <table>

            <thead>
                <tr>
                    <th class="non-border-left"><div class="line"></div><p>Наименование</p></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($storages as $storage)
                    <tr>
                        <td class="non-border-left""><div class="line"></div><a href="{{route('storages.edit', $storage)}}">{{$storage->name}}</a></td>
                    </tr>
                @endforeach

                <td colspan="5" class="non-border-left non-border-right">
                    <div class="line"></div>
                    <a href="{{route('storages.create')}}">Создать</a>
                    <div class="line"></div>
                </td>
            </tbody>

        </table>

    </div>

@endsection