<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register - Stylish Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #43cea2, #185a9d);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      padding: 2rem;
    }
    .form-control {
      border-radius: 0.5rem;
    }
    .btn-primary {
      border-radius: 0.5rem;
      font-weight: 600;
    }
    .text-danger {
      font-size: 0.875rem;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card bg-white">
        <h2 class="text-center mb-4">Register</h2>
        
        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
        
        <form action="{{ route('saveRegister') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Your full name" value="{{ old('name') }}" required>
            @error('name')
              <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" value="{{ old('email') }}" required>
            @error('email')
              <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter a secure password" required>
            @error('password')
              <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Re-enter your password" required>
          </div>
          
          <div class="text-end m-1">
            <a href="{{ route('login') }}">Already have an account?</a>
          </div>
          
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Continue</button>
          </div>
          <div class="text-center mt-3">
            <small class="text-muted">You'll receive a verification code on your email</small>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>