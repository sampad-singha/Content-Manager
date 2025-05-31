@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Content</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Content Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $content->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $content->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $content->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $content->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="media" class="form-label">Upload Media</label>
                <input type="file" name="media[]" class="form-control" multiple>
                <small class="text-muted">You can upload images, videos, documents, etc.</small>
            </div>

            @if($content->media->count())
                <div class="mb-3">
                    <label class="form-label">Existing Media</label>
                    <div class="row">
                        @foreach($content->media as $media)
                            <div class="col-md-3 mb-2 text-center">
                                @if(Str::startsWith($media->type, 'image'))
                                    <img src="{{ asset('storage/' . $media->path) }}" class="img-fluid rounded" alt="{{ $media->name }}">
                                @else
                                    <a href="{{ asset('storage/' . $media->path) }}" target="_blank">{{ $media->name }}</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Update Content</button>
        </form>
    </div>
@endsection
