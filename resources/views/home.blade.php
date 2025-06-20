@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Hello {{ Auth::user()->name }}</h3>
                        {{ __('You are logged in!') }}
                    <h6>Your email: {{ Auth::user()->email }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
