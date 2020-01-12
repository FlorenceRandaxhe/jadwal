<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Jadwal') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="body__admin">
    <header class="header header__admin">
        <div class="header__wrapper">
            <h1 class="header__title">
                <span class="sr_only">@yield('title') - Jadwal</span>
                <svg class="logo__sidebar" xmlns="http://www.w3.org/2000/svg" height="50" viewBox="0 0 407.72 138.53">
                    <g>
                        <g>
                            <path class="logo__sidebar__text" d="M167.66,90.09a1.81,1.81,0,0,1-.77-1.59q0-1.95,2.18-2l1.77-.12a6.17,6.17,0,0,0,4.48-1.86q1.47-1.68,1.48-5.4V50.8a2.37,2.37,0,0,1,2.42-2.48A2.34,2.34,0,0,1,181,49a2.5,2.5,0,0,1,.65,1.8V79.18q0,5.43-2.48,8.17t-7.49,3l-1.77.12A3.44,3.44,0,0,1,167.66,90.09Z" />
                            <path class="logo__sidebar__text" d="M228,88.44a1.88,1.88,0,0,1-.68,1.48,2.4,2.4,0,0,1-1.62.59,2.09,2.09,0,0,1-2.06-1.42l-4.19-9.56H197.15l-4.25,9.56a2.09,2.09,0,0,1-2.07,1.42,2.43,2.43,0,0,1-1.65-.62,1.93,1.93,0,0,1-.71-1.5,2.1,2.1,0,0,1,.24-.94l16.87-37.52a2.55,2.55,0,0,1,1.06-1.24,3,3,0,0,1,1.53-.41,2.94,2.94,0,0,1,1.59.44,2.76,2.76,0,0,1,1.06,1.21l16.87,37.52A2.22,2.22,0,0,1,228,88.44Zm-29-12.92h18.7l-9.38-21.18Z" />
                            <path class="logo__sidebar__text" d="M235.47,89.56a2.26,2.26,0,0,1-.68-1.71V51a2.26,2.26,0,0,1,.68-1.71,2.49,2.49,0,0,1,1.8-.65h11.51q10,0,15.43,5.4t5.46,15.37q0,10-5.49,15.4t-15.4,5.43H237.27A2.49,2.49,0,0,1,235.47,89.56Zm29.18-20.18q0-16.64-16.17-16.64h-8.85V86.08h8.85Q264.65,86.08,264.65,69.38Z" />
                            <path class="logo__sidebar__text" d="M331.44,48.65a2.33,2.33,0,0,1,1.3-.38,2.47,2.47,0,0,1,1.62.56,1.85,1.85,0,0,1,.68,1.5,3,3,0,0,1-.18.94L321.53,88.85a2.4,2.4,0,0,1-1,1.27,3,3,0,0,1-1.59.44,2.84,2.84,0,0,1-1.53-.44,2.39,2.39,0,0,1-1-1.27L304.83,56.17,293.15,88.85a2.4,2.4,0,0,1-1,1.27,2.88,2.88,0,0,1-3.07,0,2.39,2.39,0,0,1-1-1.27L274.68,51.27a2.54,2.54,0,0,1-.18-.88,1.87,1.87,0,0,1,.74-1.53,2.62,2.62,0,0,1,1.68-.59,2.48,2.48,0,0,1,1.33.38,2,2,0,0,1,.86,1.15l11.62,33.51,11.8-33.16a2.49,2.49,0,0,1,.94-1.33,2.46,2.46,0,0,1,1.42-.44,2.36,2.36,0,0,1,1.42.47,2.67,2.67,0,0,1,.94,1.36l11.62,33.22L330.61,49.8A2,2,0,0,1,331.44,48.65Z" />
                            <path class="logo__sidebar__text" d="M374.75,88.44a1.88,1.88,0,0,1-.68,1.48,2.4,2.4,0,0,1-1.62.59,2.09,2.09,0,0,1-2.06-1.42l-4.19-9.56H343.95l-4.25,9.56a2.09,2.09,0,0,1-2.07,1.42,2.43,2.43,0,0,1-1.65-.62,1.93,1.93,0,0,1-.71-1.5,2.1,2.1,0,0,1,.24-.94l16.87-37.52a2.55,2.55,0,0,1,1.06-1.24,3,3,0,0,1,1.53-.41,2.94,2.94,0,0,1,1.59.44,2.76,2.76,0,0,1,1.06,1.21l16.87,37.52A2.23,2.23,0,0,1,374.75,88.44Zm-29-12.92h18.7L355,54.34Z" />
                            <path class="logo__sidebar__text" d="M382.27,89.59a2.09,2.09,0,0,1-.68-1.62V50.8a2.49,2.49,0,0,1,.65-1.8,2.65,2.65,0,0,1,3.54,0,2.5,2.5,0,0,1,.65,1.8V86.08h19.06a2.39,2.39,0,0,1,1.65.53,2.29,2.29,0,0,1,0,3.07,2.38,2.38,0,0,1-1.65.53H383.95A2.4,2.4,0,0,1,382.27,89.59Z" />
                            <circle class="logo__sidebar__circle" cx="69.27" cy="69.27" r="69.27" />
                            <rect class="logo__sidebar__rec" x="33.87" y="49.8" width="70.78" height="43.48" />
                            <rect class="logo__sidebar__rec" x="33.87" y="49.8" width="70.78" height="12.96" />
                            <line class="logo__sidebar__line" x1="69.35" y1="42.47" x2="69.35" y2="54.6" />
                            <line class="logo__sidebar__line" x1="55.65" y1="42.47" x2="55.65" y2="54.6" />
                            <line class="logo__sidebar__line" x1="41.95" y1="42.47" x2="41.95" y2="54.6" />
                            <line class="logo__sidebar__line" x1="83.05" y1="42.47" x2="83.05" y2="54.6" />
                            <line class="logo__sidebar__line" x1="96.75" y1="42.47" x2="96.75" y2="54.6" />
                        </g>
                    </g>
                </svg>
            </h1>

            <ul class="header__nav">
                @auth
                    <li class="header__nav__item{{Request::is('dashboard') ? ' header__nav__item--current' : ''}}">
                        <a class="header__nav__item__link" class="" href="/sessions">
                            <svg class="svg__icon__menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            <span class="header__nav__item__hide">Dashboard</span>
                        </a>
                    </li>
                    <li class="header__nav__item{{Request::is('sessions/create') ? ' header__nav__item--current' : ''}}">
                        <a class="header__nav__item__link" href="/sessions/create">
                            <svg class="svg__icon__menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            <span class="header__nav__item__hide">Nouvelle session</span>
                        </a>
                    </li>
                    <li class="header__nav__item{{Request::is('teachers') ? ' header__nav__item--current' : ''}}">
                        <a class="header__nav__item__link" href="/teachers">
                            <svg class="svg__icon__menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            <span class="header__nav__item__hide">Les professeurs</span>
                        </a>
                    </li>
                @endauth
            </ul>

            @auth
            <div class="header__nav__item">
                <a class="header__nav__item__link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg class="svg__icon__menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    <span class="header__nav__item__hide">Se déconnecter</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            @endauth
        </div>
    </header>
    <main class="main__admin">
        @yield('content')
    </main>
</body>
</html>
