{{--get layouts--}}
@extends('layouts.app')

{{--get content--}}

@section('content')
    <div class="container">
        <h3 class="mb-4">Emails</h3>
        <div class="row">
            <form action='/email/receiver'>
                @csrf
                <input name="receiver" type="text" class="form-control mb-3" placeholder="Search by Receiver Email" value="{{ request('receiver') }}">
                <button type="submit" class="btn btn-primary">Search by Receiver</button>
            </form>
            @foreach($emails as $email)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $email->subject }}</h5>
                            <p class="card-text"><strong>Recipient:</strong> {{ $email->receiver }}</p>
                            <p class="card-text">{{ $email->body }}</p>
{{--                            <a href="{{ route('emails.edit', $email->id) }}" class="btn btn-primary">Edit</a>--}}
{{--                            <form action="{{ route('emails.destroy', $email->id) }}" method="POST" class="d-inline">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
{{--        <div class="mt-4">--}}
{{--            <a href="{{ route('emails.create') }}" class="btn btn-success">Create New Email Template</a>--}}
{{--        </div>--}}
    </div>
@endsection
