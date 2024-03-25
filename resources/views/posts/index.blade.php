@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-columns">
                {{-- Mostrem tots els posts --}}
                @foreach($posts as $post)
                <div class="card mb-4 text-bg-dark" style="max-width: 600px;">
                    <div class="card-body">
                        {{-- Enllaç al perfil de l''usuari --}}
                        <a class="text-decoration-none" style="color: inherit;"
                            href="{{ route('profile.userPosts', ['userId' => $post->user->id]) }}">
                            <p class="card-text">
                                <img src="{{ route('profile.avatar', ['filename' => $post->user->avatar]) }}"
                                    alt="User avatar" class="rounded-circle m-2" style="width: 60px;">
                                {{-- Mostrem el nick i el temps que fa desde la pujada del post --}}
                                {{'@' . $post->user->nick . ' | ' .
                                \FormatTime::LongTimeFilter($post->created_at)}}
                            </p>
                        </a>
                    </div>
                    {{-- Mostrem la imatge del post --}}
                    <img src="{{ route('posts.getImage', ['filename' => $post->image_path])  }}"
                        class="card-img-top img-fluid" style="object-fit: cover;" alt="Post image">
                    <div class="card-body">
                        {{-- Mostrem el botó de like i el comptador --}}
                        <button id="like-{{$post->id}}" class="btn bi-heart text-bg-dark like-button"
                            data-image-id="{{ $post->id }}" style="font-size: 24px;"></button>
                        <span id="like-count-{{$post->id}}">{{ $post->likes->count() }}</span>
                        {{-- Mostrem les dades de l'usuari --}}
                        <a class="text-decoration-none" style="color: inherit;"
                            href="{{ route('profile.userPosts', ['userId' => $post->user->id]) }}">
                            <p class="card-text mx-3"><span style="font-weight: bolder;">{{'@' . $post->user->nick
                                    }}</span>
                                <span style="color: rgba(255, 255, 255, 0.4);">{{$post->description }}</span>
                            </p>
                        </a>
                        <div class="comments-section mx-3 p-3">
                            {{-- Mostrem els comentaris --}}
                            @if ($post->comments->isNotEmpty())
                            <a class="text-decoration-none" style="color: inherit;"
                                href="{{ route('profile.userPosts', ['userId' => $post->comments->first()->user->id]) }}">
                                <div class="comment">
                                    <span style="font-weight: bolder;">{{'@' . $post->comments->first()->user->nick
                                        }}</span>
                                    <span style="color: rgba(255, 255, 255, 0.4);">{{$post->comments->first()->content
                                        }}</span>
                                </div>
                            </a>
                            {{-- Si hi ha comentaris, mostrem 'See al comments' --}}
                            @if ($post->comments->count() >= 1)
                            <a href="{{ route('posts.comments.showComments', ['id' => $post->id]) }}" class="mt-2 mx-3"
                                style="text-decoration: none; color: rgba(255, 255, 255, 0.3); ">See all comments</a>
                            @endif
                            @else
                            {{-- Si no hi ha comentaris, mostrem 'Post one!' --}}
                            <div class="no-comment">
                                <span style="color: rgba(255, 255, 255, 0.3);">
                                    There are no comments yet...
                                    <a href="{{ route('posts.comments.showComments', ['id' => $post->id]) }}"
                                        style="text-decoration: none; color: inherit;">Post one!</a></span>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach
                <div class="d-flex justify-content-center vertical-pagination">
                    {{-- Mostrem la paginació dels posts --}}
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Importem el modul per actualitzar els likes --}}
<script type="module" src="{{ asset('js/indexLike.js') }}"></script>