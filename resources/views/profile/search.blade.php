@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4 text-center">Search Results</h2>
    <div class="row">
        {{-- Verificar que hi hagi usuaris existents amb les dades de la cerca --}}
        @if($users->isNotEmpty())
        {{-- Mostrem tots els usuaris --}}
        @foreach ($users as $user)
        <div class="col-md-4 mb-4">
            {{-- Enllaç al perfil de l'usuari --}}
            <a href="{{ route('profile.userPosts', ['userId' => $user->id]) }}" class="text-decoration-none text-white">
                <div class="card text-bg-dark h-100">
                    <div class="card-body d-flex flex-row-reverse justify-content-center align-items-center">
                        <div class="text-start">
                            {{-- Mostrem la imatge, el nick, nom i cognoms --}}
                            <p class="mb-0 fw-bold">{{ '@'.$user->nick }}</p>
                            <p class="mb-0">{{ $user->name }} {{ $user->surname }}</p>
                        </div>
                        <img src="{{ route('profile.avatar', ['filename' => $user->avatar ?? 'defaultAvatar.png']) }}"
                            alt="User avatar" class="rounded-circle me-4"
                            style="width: 60px; height: 60px; object-fit: cover;">
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @else
        {{-- Si no hi ha cap usuari amb aquelles dades, mostrem error --}}
        <div class="col">
            <p class="text-center">No users found.</p>
        </div>
        @endif
    </div>
</div>
@endsection