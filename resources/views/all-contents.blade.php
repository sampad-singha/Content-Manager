@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Contents</h2>
        <div class="mb-3">
            <a href="{{ route('contents.create') }}" class="btn btn-success">Create New Content</a>
        </div>
        @if($contents->count())
{{--            {{dd($contents)}}--}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" action="{{ route('contents.index') }}" class="mb-3 d-flex align-items-center">
                    <label for="per_page" class="me-2">Show</label>
                    <select name="per_page" id="per_page" class="form-select w-auto me-2" onchange="this.form.submit()">
                        @foreach([5, 10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span>entries</span>
                </form>
                <a href="{{ route('contents.export') }}" class="btn btn-outline-primary mb-3">Export as CSV</a>
            </div>
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contents as $content)
                    <tr>
                        <td>{{$content->id}}</td>
                        <td>{{ $content->name }}</td>
                        <td>{{ ucfirst($content->status) }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ url('contents/' . $content->id) }}">Details</a>
                            <form action="{{ route('contents.destroy', $content->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this content?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $contents->appends(['per_page' => $perPage])->links('pagination::bootstrap-4') }}
            </div>
        @else
            <p>No contents found.</p>
        @endif
    </div>
@endsection
