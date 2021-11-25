<div class="dashboard__menu">
    
    <div class="menu__group">

        <div class="group__title"><p>Основное</p></div>

        <div class="group__item {{Request::is('/') ? 'active' : '' }}">
            <a href="{{route('index')}}">Основная</a>
        </div>

        <div class="group__item {{Request::is('/dashboard*') ? 'active' : '' }}">
            <a href="{{route('index')}}">Продукты</a>
        </div>

        <div class="group__item {{Request::is('/dashboard*') ? 'active' : '' }}">
            <a href="{{route('index')}}">Заказы</a>
        </div>

        <div class="group__item {{Request::is('/fsdfd*') ? 'active' : '' }}">
            <a href="{{route('index')}}">Пользователи</a>
        </div>

    </div>

    <div class="menu__group">

        <div class="group__title"><p>Логистика</p></div>

        <div class="group__item {{Request::is('/dashboard*') ? 'active' : '' }}">
            <a href="{{route('index')}}">Склады</a>
        </div>

        <div class="group__item {{Request::is('/dashboard*') ? 'active' : '' }}">
            <a href="{{route('index')}}">Лог</a>
        </div>

        <div class="group__item {{Request::is('/dashboard*') ? 'active' : '' }}">
            <a href="{{route('index')}}">Типы логов</a>
        </div>

    </div>

</div>