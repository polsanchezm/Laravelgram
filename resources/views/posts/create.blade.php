@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-bg-dark">
                <div class="card-header">{{ __('Upload Image') }}</div>

                <div class="card-body">
                    {{-- Formulari per crear un post --}}
                    <form action="{{ route('posts.uploadPost') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image" class="form-label">CHOOSE IMAGE</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">DESCRIPTION</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 text-bg-dark">UPLOAD IMAGE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection