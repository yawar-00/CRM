<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #00b4db, #0083b0);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    
    .card {
      border: none;
      border-radius: 1.5rem;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      padding: 2.5rem;
      max-width: 450px;
      width: 100%;
      transition: all 0.3s ease;
      margin: 0 auto;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 35px rgba(0, 0, 0, 0.25);
    }
    
    .logo-container {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    
    .logo {
      font-size: 2.5rem;
      color: #0083b0;
      background: #f8f9fa;
      width: 70px;
      height: 70px;
      line-height: 70px;
      border-radius: 50%;
      display: inline-block;
      box-shadow: 0 5px 15px rgba(0, 131, 176, 0.2);
    }
    
    h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: #333;
      font-weight: 600;
    }
    
    .form-control {
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      border: 1px solid #e0e0e0;
      box-shadow: none;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      box-shadow: 0 0 0 3px rgba(0, 131, 176, 0.25);
      border-color: #0083b0;
    }
    
    .form-label {
      font-weight: 500;
      color: #555;
    }
    
    .btn-primary {
      border-radius: 0.75rem;
      font-weight: 600;
      padding: 0.75rem 1.5rem;
      background: linear-gradient(to right, #00b4db, #0083b0);
      border: none;
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      background: linear-gradient(to right, #0083b0, #006f94);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 131, 176, 0.3);
    }
    
    .error {
      color: #dc3545;
      font-size: 0.9rem;
      margin-top: 0.5rem;
      padding: 0.5rem 1rem;
      background-color: rgba(220, 53, 69, 0.1);
      border-radius: 0.5rem;
    }
    
    .email-display {
      background-color: #f8f9fa;
      border-radius: 0.75rem;
      padding: 0.75rem 1.25rem;
      margin-bottom: 1.5rem;
      border-left: 4px solid #0083b0;
      font-weight: 500;
    }
    
    .email-value {
      color: #0083b0;
      word-break: break-all;
    }
    
    .otp-input {
      letter-spacing: 3px;
      font-weight: 600;
      text-align: center;
    }
    
    .divider {
      margin: 1.5rem 0;
      border-top: 1px solid #e0e0e0;
      position: relative;
    }
    
    .divider-text {
      position: absolute;
      top: -10px;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      padding: 0 15px;
      color: #6c757d;
      font-size: 0.9rem;
    }
    
    .card-footer {
      text-align: center;
      margin-top: 1.5rem;
      color: #6c757d;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card bg-white">
        <div class="logo-container">
          <div class="logo">
            <i class="fas fa-lock"></i>
          </div>
        </div>
        <h2>Password Recovery</h2>
        
        @if(session('otp_sent'))
          <div class="email-display">
            <i class="fas fa-envelope me-2"></i> Verification code sent to: 
            <div class="email-value">{{ session('email') }}</div>
          </div>
          
          <form action="{{ route('verify.otp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}" required>
            <div class="mb-4">
              <label for="otp" class="form-label">Enter Verification Code</label>
              <input type="text" name="otp" class="form-control otp-input" placeholder="Enter your OTP" required>
              @if(session('error'))
                <div class="error">
                  <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
              @endif
            </div>
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle me-2"></i> Verify Code
              </button>
            </div>
          </form>
          
          <div class="divider">
            <span class="divider-text">OR</span>
          </div>
          
          <form action="{{ route('send.otp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}" required>
            <div class="d-grid">
              <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-redo me-2"></i> Resend Verification Code
              </button>
            </div>
          </form>
          
        @else
          <form action="{{ route('send.otp') }}" method="POST">
            @csrf
            <div class="mb-4">
              <label for="email" class="form-label">Email Address</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="fas fa-envelope text-muted"></i>
                </span>
                <input type="email" name="email" class="form-control border-start-0" placeholder="Enter your email" required>
              </div>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i> Send Verification Code
              </button>
            </div>
          </form>
        @endif
        
        <div class="card-footer">
          <p>Remember your password? <a href="{{route('login')}}" class="text-decoration-none">Back to Login</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>