@extends('layouts.app')

@section('title', 'Login')

@section('content')
  <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 20px; background-color: #ffffff; color: #000;">
      <h4 class="mb-4 text-center">Login</h4>

      @if ($errors->any())
        <div class="alert alert-danger">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" class="form-control" id="username" required autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn w-100 text-white" style="background-color: #6c0d7a;">Login</button>

        <div class="text-center mt-3">
          <a href="{{ url('/register') }}" class="text-decoration-none text-muted">Don't have an account? Register</a>
        </div>
      </form>
    </div>
  </div>
@endsection