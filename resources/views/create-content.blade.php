@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Content</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contents.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Content Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" >Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="media" class="form-label">Upload Media</label>
                <input type="file" name="media[]" class="form-control" multiple>
                <small class="text-muted">You can upload images, videos, documents, etc.</small>
            </div>

            <button type="submit" class="btn btn-primary">Create Content</button>
        </form>
    </div>
@endsection
