@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card text-bg-dark d-flex flex-column justify-content-center">
            <div class="row g-0">
                {{-- Mostrem la imatge del post --}}
                <div class="col-md-6 d-flex flex-column justify-content-center">
                    <img src="{{ route('posts.getImage', ['filename' => $post->image_path]) }}" alt="Post image">
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center px-3 py-2">
                        {{-- Enllaç al perfil de l'usuari --}}
                        <a class="text-decoration-none" style="color: inherit;"
                            href="{{ route('profile.userPosts', ['userId' => $post->user->id]) }}">
                            <div class="card-header d-flex align-items-center px-3">
                                <img src="{{ route('profile.avatar', ['filename' => $post->user->avatar]) }}"
                                    class="rounded-circle me-3" style="width: 50px; height: 50px;" alt="User avatar">
                                <h5 class="mb-0">{{ '@' . $post->user->nick }}</h5>
                            </div>
                        </a>
                        {{-- Verificar si l'usuari es el propietari del post per mostrar el botó d'eliminar el post --}}
                        @if (Auth::user()->id == $post->user->id)
                        <div class="dropdown">
                            <button class="btn btn-link" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                style="text-decoration: none; color: inherit;">
                                &#8942;
                            </button>
                            <form action="{{ route('posts.deletePost', ['id' => $post->id]) }}" method="post">
                                @csrf
                                <div class="dropdown-menu text-bg-dark" style="border: 2px solid grey;">
                                    <button class="dropdown-item text-center text-bg-dark" type="submit">DELETE
                                        POST</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        {{-- Botó per fer like i comptador de likes --}}
                        <button id="like" class="btn bi-heart text-bg-dark" data-image-id="{{ $post->id }}"
                            style="font-size: 24px;"></button>
                        <span id="like-count">{{ $post->likes->count() }}</span>

                        {{-- Mostrem tots els comentaris del post amb el nick de l'usuari --}}
                        @foreach($comments as $comment)
                        <div class="d-flex align-items-center justify-content-start mx-1 px-1 py-2">
                            <div style="flex-grow: 1;">
                                <a class="text-decoration-none" style="color: inherit;"
                                    href="{{ route('profile.userPosts', ['userId' => $comment->user->id]) }}">
                                    <span style="font-weight: bolder;">
                                        {{'@' . $comment->user->nick }}
                                    </span>
                                </a>
                                <span style=" color: rgba(255, 255, 255, 0.4);">
                                    {{-- Afegim helper per si al comentari existeix el tag a un usuari
                                    (no és funcional, només canvia el color si s'escriu '@username') --}}
                                    {!! \App\Helpers\HighlightUsername::highlightUsernames($comment->content) !!}
                                </span>
                            </div>
                            {{-- Verificar si l'usuari es el propietari del comentari per mostrar el botó d'eliminar el
                            comentari --}}
                            @if (Auth::user()->id == $comment->user_id)
                            <div class="dropdown">
                                <button class="btn btn-link" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="text-decoration: none; color: inherit;">
                                    &#8942;
                                </button>
                                <form action="{{ route('posts.comments.deleteComment', ['id' => $comment->id]) }}"
                                    method="post">
                                    @csrf
                                    <div class="dropdown-menu text-bg-dark" style="border: 2px solid grey;">
                                        <button class="dropdown-item text-center text-bg-dark" type="submit">DELETE
                                            COMMENT</button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        <div class="mt-3 mx-2 pt-2">
                            {{-- Mostrem la paginació de comentari --}}
                            {{ $comments->links() }}
                        </div>
                    </div>


                    <div class="card-body">
                        {{-- Formulari per afegir comentari --}}
                        <form action="{{ route('posts.comments.uploadComment', ['id' => $post->id])  }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col mx-1 px-1">
                                    <textarea class="form-control" id="comment" name="comment" rows="1"
                                        placeholder="Add a comment..."></textarea>
                                </div>
                                <div class="col-auto mx-1 px-1">
                                    <button type="submit" class="btn btn-primary text-bg-dark">SEND</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Importem el modul per actualitzar els likes --}}
<script type="module" src="{{ asset('js/detailLike.js') }}"></script>