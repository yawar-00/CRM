<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Stylish Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
      body {
        background: #1861a1;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Arial, sans-serif;
      }
      
      .login-container {
        display: flex;
        max-width: 900px;
        margin: 0 auto;
      }
      
      .illustration-container {
        background-color: transparent;
       
        padding: 1rem;
        position: relative;
        max-width: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .login-box {
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        padding: 2.5rem;
        width: 100%;
        max-width: 450px;
      }
      
      .login-title {
        color: #6c7ae0;
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 2rem;
        font-weight: 500;
      }
      
      .input-group {
        margin-bottom: 1.5rem;
      }
      
      .input-group-text {
        border: none;
        background-color: transparent;
      }
      
      .form-control {
        border: none;
        border-bottom: 1px solid #e0e0e0;
        border-radius: 0;
        padding-left: 0;
      }
      
      .form-control:focus {
        box-shadow: none;
        border-color: #6c7ae0;
      }
      
      .form-check-input:checked {
        background-color: #6c7ae0;
        border-color: #6c7ae0;
      }
      
      .btn-primary {
        background-color: #5e72e4;
        border: none;
        border-radius: 25px;
        padding: 0.75rem 0;
        font-weight: 500;
        margin-top: 1rem;
        transition: all 0.3s;
      }
      
      .btn-primary:hover {
        background-color: #4a5cd0;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(94, 114, 228, 0.3);
      }
      
      .form-text, .forgot-link {
        text-align: center;
        margin-top: 1rem;
        color: #8898aa;
      }
      
      a {
        color: #5e72e4;
        text-decoration: none;
      }
      
      a:hover {
        text-decoration: underline;
      }
      
      .account-options {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-size: 0.9rem;
      }
      
      @media (max-width: 767.98px) {
        .login-container {
          flex-direction: column;
          align-items: center;
        }
        
        .illustration-container {
          display: none;
        }
        
        .login-box {
          max-width: 100%;
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="login-container">
        <!-- Illustration Side -->
        <div class="illustration-container me-4 d-none d-md-flex">
          <img src="{{ asset('assets/images/login-register-illustration.png') }}" alt="Register Illustration" width="100%">
        </div>
        
        <!-- Login Form -->
        <div class="login-box">
          <h2 class="login-title">Login Here !</h2>
          
          <form action="{{ route('saveLogin') }}" method="POST">
            @csrf
            
            <div class="input-group mb-3">
              <span class="input-group-text">
                <i class="fas fa-user"></i>
              </span>
              <input type="email" name="email" class="form-control" id="email" placeholder="User Name" value="{{ old('email') }}">
            </div>
            @error('email')
              <div class="text-danger mb-3" style="margin-top: -10px;">{{ $message }}</div>
            @enderror
            
            <div class="input-group mb-3">
              <span class="input-group-text">
                <i class="fas fa-lock"></i>
              </span>
              <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
            @error('password')
              <div class="text-danger mb-3" style="margin-top: -10px;">{{ $message }}</div>
            @enderror
            
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="rememberPassword">
              <label class="form-check-label" for="rememberPassword">Remember Password</label>
            </div>
            
            <div class="account-options">
              <span>Don't Have an Account?</span>
              <a href="{{ route('register') }}">Create an Account</a>
            </div>
            
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            
            <div class="forgot-link">
              <a href="{{ route('forgot.form') }}">Forget Password ?</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>