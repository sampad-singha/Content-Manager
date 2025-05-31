@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/email/create" method="POST">
            @csrf
            <input type="text" name="subject" class="form-control mb-3" placeholder="Subject">
            <input type="email" name="receiver" class="form-control mb-3" placeholder="Receiver Email">
            <textarea name="body" class="form-control mb-3" placeholder="Email Body"></textarea>

            <button type="submit" class="btn btn-primary">Create Email</button>
        </form>
    </div>
@endsection
