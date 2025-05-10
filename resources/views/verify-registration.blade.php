<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Verify Registration - OTP</title>
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
      letter-spacing: 1.5px;
      text-align: center;
      font-size: 1.5rem;
    }
    .btn-primary {
      border-radius: 0.5rem;
      font-weight: 600;
    }
    .text-danger {
      font-size: 0.875rem;
    }
    .otp-message {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 0.5rem;
      padding: 0.75rem;
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card bg-white">
        <h2 class="text-center mb-4">Verify Your Email</h2>
        
        <div class="otp-message text-center">
          <p class="mb-1">We've sent a verification code to:</p>
          <p class="mb-0 fw-bold">{{ $email }}</p>
        </div>
        
        @if(session('message'))
          <div class="alert alert-success">
            {{ session('message') }}
          </div>
        @endif
        
        <form action="{{ route('verify.registration') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label for="otp" class="form-label">Enter 6-Digit Code</label>
            <input type="text" name="otp" class="form-control" id="otp" maxlength="6" required>
            @error('otp')
              <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-lg">Verify & Complete Registration</button>
          </div>
        </form>
        
        <div class="text-center mt-3">
          <p>Didn't receive the code?</p>
          <form action="{{ route('resend.registration.otp') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link">Resend OTP</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Focus on OTP input when page loads
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('otp').focus();
  });
  
  // Only allow numbers in OTP field
  document.getElementById('otp').addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
  });
</script>
</body>
</html>