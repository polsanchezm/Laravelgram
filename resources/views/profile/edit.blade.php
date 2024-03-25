@extends('layouts.app')

@section('content')
{{-- Formulari per editar el perfil, a cada camp tenim validacions i mostrem els missatges d'error de cada camp --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-bg-dark">
                <div class="card-header text-center">Edit Profile</div>
                <div class="card-body">

                    <ul class="nav nav-tabs justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="#profileInfoTab" data-bs-toggle="tab">PROFILE
                                INFORMATION</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#credentialsTab" data-bs-toggle="tab">CREDENTIALS</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profileInfoTab">
                            <div class="row justify-content-center">
                                <div class="col-md-12 p-4">
                                    <form method="POST" action="{{ route('profile.update.profileInfo') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3 row">
                                            <label for="name" class="col-md-4 col-form-label text-md-end">NAME</label>
                                            <div class="col-md-6">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name', auth()->user()->name) }}">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="surname"
                                                class="col-md-4 col-form-label text-md-end">SURNAME</label>
                                            <div class="col-md-6">
                                                <input type="text"
                                                    class="form-control @error('surname') is-invalid @enderror"
                                                    id="surname" name="surname"
                                                    value="{{ old('surname', auth()->user()->surname) }}">
                                                @error('surname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="nick" class="col-md-4 col-form-label text-md-end">NICK</label>

                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">@</span>
                                                    <input type="text"
                                                        class="form-control @error('nick') is-invalid @enderror"
                                                        id="nick" name="nick"
                                                        value="{{ old('nick', auth()->user()->nick) }}"
                                                        aria-describedby="basic-addon1">
                                                </div>
                                                @error('nick')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="avatar"
                                                class="col-md-4 col-form-label text-md-end">AVATAR</label>
                                            <div class="col-md-6">
                                                <div>
                                                    <img src="{{ route('profile.avatar', ['filename' => Auth::user()->avatar ?? 'defaultAvatar.png']) }}"
                                                        alt="User avatar" class="img-thumbnail p-2 mb-3"
                                                        style="max-width: 180px;">
                                                </div>
                                                <input type="file"
                                                    class="form-control @error('avatar') is-invalid @enderror"
                                                    id="avatar" name="avatar">
                                                @error('avatar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="credentialsTab">
                            <div class="row justify-content-center">
                                <div class="col-md-12 p-4">
                                    <form method="POST" action="{{ route('profile.update.credentials') }}">
                                        @csrf

                                        <div class="mb-3 row">
                                            <label for="email" class="col-md-4 col-form-label text-md-end">EMAIL</label>
                                            <div class="col-md-6">
                                                <input type="text"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email', auth()->user()->email) }}">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="password"
                                                class="col-md-4 col-form-label text-md-end">PASSWORD</label>
                                            <div class="col-md-6">
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password-confirm"
                                                class="col-md-4 col-form-label text-md-end">CONFIRM PASSWORD</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection