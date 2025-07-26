@extends('layouts.app')

@section('title', 'Register')

@section('content')
  <div class="card bg-dark text-white shadow-lg p-4" style="max-width: 500px; margin: auto;">
    <h3 class="text-center mb-4">Register</h3>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div> 
    @endif

    <form action="{{ route('register') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required value="{{ old('username') }}">
      </div>

      
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      
      <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" class="form-select" required>
          <option value="" disbaled selected>--- Role ---</option>
          <option value="admin">Admin</option>
          <option value="operator" hidden>Operator</option>
          <option value="owner" hidden>Owner</option>
        </select>
      </div>
      
      <button type="submit" class="btn btn-primary w-100" style="background-color: #6c0d7a; border: none;">Register</button>
      
      <div class="mt-3 text-center">
        <a href="{{ route('login') }}" class="text-white text-decoration-underline">Already have an account? Login</a>
      </div>
    </form>
  </div>
@endsection