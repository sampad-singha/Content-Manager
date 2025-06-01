@extends('layouts.app')

@push('styles')
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <!-- EasyMDE -->
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">

@endpush

@section('content')
    <div class="container">
        <h2>Edit Content</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Content Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $content->name) }}" required>
            </div>

            <!-- EasyMDE Editor -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="markdown-editor" name="description">{{ old('description', $content->description) }}</textarea>
            </div>

            <!-- CKEditor -->
            <div class="mb-3">
                <label for="content" class="form-label">Main Content</label>
                <textarea id="ckeditor" name="content">{{ old('content', $content->content ?? '') }}</textarea>
            </div>

            <div id="summernote">Hello Summernote</div>

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

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- EasyMDE -->
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // EasyMDE
            new EasyMDE({element: document.getElementById("markdown-editor"),
                uploadImage: true,
                imageUploadEndpoint: "imageUpload",
                promptURLs: true,
            });

            // CKEditor
            ClassicEditor
                .create(document.querySelector('#ckeditor'))
                .then(editor => {
                    console.log('CKEditor initialized');
                })
                .catch(error => {
                    console.error('CKEditor error:', error);
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endpush
