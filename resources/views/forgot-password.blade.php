<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #00b4db, #0083b0);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      padding: 2rem;
    }
    .form-control {
      border-radius: 0.5rem;
    }
    .btn-primary {
      border-radius: 0.5rem;
      font-weight: 600;
    }
    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }
    .error-list {
      color: red;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card bg-white">
        <h2>Forgot Password</h2>

        @if(session('otp_sent'))
          
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" name="email" class="form-control" value="{{ session('email') }}" readonly>
            </div>
            <div>
            <form action="{{ route('send.otp') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="hidden" name="email" class="form-control" value="{{ session('email') }}" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Re-send OTP</button>
                </div>
            </form>
            </div>
            <form action="{{ route('verify.otp') }}" method="POST">
            @csrf
            
            <input type="hidden" name="email" class="form-control" value="{{ session('email') }}" required>
            <div class="mb-3">
              <label for="otp" class="form-label">Enter OTP</label>
              <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Verify OTP</button>
            </div>
          </form>
        @else
          <form action="{{ route('send.otp') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Send OTP</button>
            </div>
          </form>
        @endif

        @if($errors->any())
          <div class="error-list">
            <ul class="mt-3">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
