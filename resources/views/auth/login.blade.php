<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Stylish Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
      body {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      }
      .form-control {
        border-radius: 0.5rem;
      }
      .btn-primary {
        border-radius: 0.5rem;
        font-weight: 500;
      }
      .form-text {
        color: #ccc;
      }
      a {
        font-size: 0.9rem;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card p-4 bg-white">
            <h2 class="text-center mb-4">Login</h2>
            <form action="{{ route('saveLogin') }}" method="POST">
  @csrf

  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="{{ old('email') }}">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    @error('email')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password">
    

    @error('password')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
  </div>
  <div class="d-flex justify-content-between">
  <div class="text m-1">
    <a href="{{ route('register') }}">Don't have a account yet?</a>
  </div>
  <div class="text-end mt-1">
      <a href="{{ route('forgot.form') }}">Forgot Password?</a>
  </div>
  </div>
  

  <div class="d-grid">
    <button type="submit" class="btn btn-primary btn-lg">Login</button>
  </div>
</form>

          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>
