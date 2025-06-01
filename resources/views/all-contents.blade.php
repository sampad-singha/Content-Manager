@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Contents</h2>
        <div class="mb-3">
            <a href="{{ route('contents.create') }}" class="btn btn-success">Create New Content</a>
        </div>
        <div class="mb-3 d-flex gap-3">
            <select id="filter-university" class="form-control">
                <option value="">All Universities</option>
                @foreach($universities as $university)
                    <option value="{{ $university }}">{{ $university }}</option>
                @endforeach
            </select>

            <select id="filter-status" class="form-control">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        {!! $dataTable->table(['class' => 'table table-bordered table-striped'], true) !!}

    </div>
@endsection
@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function() {
            var table = $('#content-table').DataTable();

            $('#filter-university').on('change', function () {
                table.column(2).search(this.value).draw(); // university column index 2
            });

            $('#filter-status').on('change', function () {
                var val = this.value;
                if(val) {
                    table.column(3).search('^' + val + '$', true, false).draw(); // regex exact match
                } else {
                    table.column(3).search('').draw(); // clear filter
                }
            });

        });
    </script>
@endpush

