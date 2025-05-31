@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Emails</h3>
        <div class="row">
            @foreach($emails as $email)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $email->subject }}</h5>
                            <p class="card-text"><strong>Recipient:</strong> {{ $email->receiver }}</p>
                            <p class="card-text">{{ $email->body }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
