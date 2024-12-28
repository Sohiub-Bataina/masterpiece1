@extends('user-side.components.app')

@section('content')
    <div class="container mt-5">
        <h1>Welcome, {{ auth()->user()->name }}</h1>
        <p>Email: {{ auth()->user()->email }}</p>
        <a href="{{ route('user-side.home') }}" class="btn btn-primary">Back to Home</a>
    </div>
@endsection
