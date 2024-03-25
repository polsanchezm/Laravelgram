<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'INSTAGRAM') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="d-flex">
            <div class="flex-shrink-0 p-4 text-bg-dark justify-content-center"
                style="width: 270px; height: 100%; position: fixed;">
                <ul class="nav nav-pills flex-column mb-4">
                    <li class="nav-item">
                        <a class="navbar-brand mx-1" href="{{ url('/') }}">
                            <i class="bi bi-camera-fill"></i>
                            <span class="mx-2">{{ config('app.name', 'INSTAGRAM') }}</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-pills flex-column mt-4 mb-4">
                    <li class="nav-item my-2">
                        {{-- Enllaç per crear un post --}}
                        <a class="nav-item mx-1 text-white text-decoration-none" href="{{ route('posts.createPost') }}">
                            <i class="bi bi-plus-square-fill"></i>
                            <span class="mx-2">{{__('CREATE') }}</a></span>
                    </li>
                </ul>
            </div>

            <div class="flex-grow-1">
                <main class="py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="max-width: 800px;">
                                {{-- Formulari de cerca d'usuaris --}}
                                <div class="card text-bg-dark mb-4 p-2">
                                    <div class="card-header">
                                        <form action="{{ route('profile.searchProfile') }}" method="GET"
                                            class="d-flex justify-content-end">
                                            <div class="input-group">
                                                <input type="text" name="search" required placeholder="Search Users..."
                                                    class="form-control rounded-start" aria-label="Search users">
                                                <button class="btn btn-outline-light" type="submit">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- Mostrem els missatges que hi hagin --}}
                                @if (session('message'))
                                <div class="alert alert-success text-center" role="alert">
                                    {{ session('message') }}
                                </div>
                                @endif
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div class="flex-shrink-0 p-4 text-bg-dark justify-content-center"
                style="width: 270px; height: 100%; right: 0; position: fixed;">
                <ul class="nav nav-pills flex-column mb-auto">
                    {{-- Verificar si l'usuari esta loguejat, si no ho está, mostrem rutes login i register --}}
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">{{ __('REGISTER') }}</a>
                    </li>
                    <hr>
                    @endif
                    @else
                    <div class="mt-auto">
                        {{-- Dropdown per mostrar les rutes del perfil --}}
                        <div class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                                style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                                <img src="{{ route('profile.avatar', ['filename' => Auth::user()->avatar ?? 'defaultAvatar.png']) }}"
                                    alt="User avatar" class="rounded-circle"
                                    style="width: 40px; height: 40px; object-fit: cover; margin-right: 5px;">
                                <span style="margin-right: 20px; white-space: nowrap;">{{ '@' . Auth::user()->nick
                                    }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark"
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('profile.userPosts', ['userId' => Auth::user()->id]) }}">VIEW
                                    PROFILE</a>

                                <a class="dropdown-item" href="{{ route('profile.editProfile') }}">EDIT PROFILE</a>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    {{ __('LOGOUT') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</body>
</html>