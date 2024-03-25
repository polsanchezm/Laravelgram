@extends('layouts.app')

@section('content')
<div class="container">
    <div class="user-profile mb-5">
        <div class="row align-items-center">
            <div class="col-auto">
                {{-- Mostrem la imatge de l'usuari --}}
                <img src="{{ route('profile.avatar', ['filename' => $user->avatar ?? 'defaultAvatar.png']) }}"
                    class="rounded-circle" alt="User Avatar" style="width: 100px; height: 100px; object-fit: cover;">
            </div>
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    {{-- Mostrem el nickname de l'usuari --}}
                    <h4 class="mb-0">{{ '@'.$user->nick }}</h4>
                    {{-- Si es el propietari del perfil, mostrem botó per editar-lo --}}
                    @if (Auth::user()->id == $user->id)
                    <a class="btn btn-primary text-bg-dark" href="{{ route('profile.editProfile') }}">EDIT PROFILE</a>
                    @endif
                </div>
                <div class="mt-2">
                    {{-- Mostrem nom i cognoms --}}
                    <p>{{ $user->name }} {{ $user->surname }}</p>
                </div>
                <div>
                    {{-- Mostrem quants posts té el perfil --}}
                    <span><strong>{{ $user->images_count }}</strong> posts</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- Mostrem tots els posts de l'usuari sense les dades, només la imatge --}}
        @foreach($user->images as $image)
        <div class="col-md-4 col-sm-6 mb-4">
            {{-- Enllaç al post on veiem els detalls del post --}}
            <a href="{{ route('posts.comments.showComments', ['id' => $image->id]) }}">
                <div class="card text-bg-dark" style="width: 100%;">
                    <img src="{{ route('posts.getImage', ['filename' => $image->image_path]) }}"
                        class="card-img-top img-fluid" alt="Post image" style="height: 250px; object-fit: cover;">
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection