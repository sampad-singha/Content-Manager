@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Site Settings</h2>

        {{-- Current Settings Preview --}}
        <div class="card mb-4">
            <div class="card-header">Current Settings</div>
            <div class="card-body">
                <p><strong>App Name:</strong> {{ $app_name ?? 'Not Set' }}</p>

                @if ($logo)
                    <p><strong>Logo:</strong></p>
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" width="150">
                @else
                    <p><strong>Logo:</strong> Not uploaded</p>
                @endif

                @if($socials && $socials->count())
                    <p class="mt-4"><strong>Social Links</strong></p>
                    <ul>
                        @foreach($socials as $social)
                            <li>
                                <strong>{{ $social->name }}</strong>:
                                <a href="{{ $social->url }}" target="_blank">{{ $social->url }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No social links found.</p>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <h2>Update Settings</h2>
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="app_name" class="form-label"><strong>App Name</strong></label>
                <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $app_name) }}">
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label"><strong>Logo</strong></label>
                <input type="file" name="logo" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Social Links</strong></label>
                <div id="social-links-wrapper">
                    @foreach($socials as $social)
                        <div class="social-link d-flex align-items-center gap-2 mb-2">
                            <input type="text" name="social_links[{{ $loop->index }}][name]" class="form-control w-25 me-2" placeholder="Platform Name (e.g., Facebook)" value="{{ $social->name }}">
                            <input type="url" name="social_links[{{ $loop->index }}][url]" class="form-control w-25 me-2" placeholder="URL (e.g., https://facebook.com/user)" value="{{$social->url}}">
                            <button type="button" class="btn btn-danger remove-link">Remove</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-social-link" class="btn btn-success rounded mt-2">+ Add Link</button>
            </div>

            <button type="submit" class="btn btn-primary">Update Settings</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let index = {{ $socials->count() }}; // Start from 1 since 0 is used in the first field

        $('#add-social-link').click(function () {
            let html = `
            <div class="social-link d-flex align-items-center gap-2 mb-2">
                <input type="text" name="social_links[${index}][name]" class="form-control w-25 me-2" placeholder="Platform Name (e.g., Facebook)" required>
                <input type="url" name="social_links[${index}][url]" class="form-control w-25 me-2" placeholder="URL (e.g., https://facebook.com/user)" required>
                <button type="button" class="btn btn-danger remove-link">Remove</button>
            </div>`;
            $('#social-links-wrapper').append(html);
            index++;
        });

        $(document).on('click', '.remove-link', function () {
            $(this).closest('.social-link').remove();
        });
    </script>
@endsection
