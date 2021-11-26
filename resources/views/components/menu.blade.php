<div class="dashboard__menu">
    
    <div class="menu__group">

        <div class="group__title"><p>Основное</p></div>

        <div class="group__item {{Request::is('/') ? 'active' : '' }}">
            <a href="{{route('index')}}">Основная</a>
        </div>

        <div class="group__item {{Request::is('/dashboard') ? 'active' : '' }}">
            <a href="{{route('index')}}">Заказы</a>
        </div>

        <div class="group__item {{Request::is('storages*') ? 'active' : '' }}">
            <a href="{{route('storages')}}">Склады</a>
        </div>

        <div class="group__item {{Request::is('logs*') ? 'active' : '' }}">
            <a href="{{route('logs')}}">Логи</a>
        </div>

    </div>

    <div class="menu__group">

        <div class="group__title"><p>Инструменты</p></div>

        <div class="group__item {{Request::is('tools/storages*') ? 'active' : '' }}">
            <a href="{{route('storages.tools')}}">Склады</a>
        </div>

        <div class="group__item {{Request::is('tools/products*') ? 'active' : '' }}">
            <a href="{{route('products')}}">Продукты</a>
        </div>

        <div class="group__item {{Request::is('tools/users*') ? 'active' : '' }}">
            <a href="{{route('users')}}">Пользователи</a>
        </div>

        <div class="group__item {{Request::is('tools/logs-type*') ? 'active' : '' }}">
            <a href="{{route('logs.type.index')}}">Типы логов</a>
        </div>

    </div>

</div>