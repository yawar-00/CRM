
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forget Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      margin: 0 40px;
      padding: 0;
      background-color: #fff;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      overflow: hidden;
    }

    .container-custom {
      display: flex;
      height: 100vh;
    }

    .left-section {
      flex: 1.2;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #fff;
    }

    .left-section img {
      max-width: 90%;
      height: auto;
    }

    .right-section {
      flex: 0.8;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px 100px;
    }

    .form-title {
      font-size: 36px;
      font-weight: 600;
      margin-bottom: 30px;
      line-height: 1.3;
    }

    .input-wrapper {
      position: relative;
      margin-bottom: 20px;
      border-bottom: 1px solid #ccc;
      display: flex;
      align-items: center;
      padding-bottom: 5px;
    }

    .input-wrapper i {
      margin-right: 10px;
      color: #000;
    }

    .input-wrapper input {
      border: none;
      outline: none;
      background: transparent;
      width: 100%;
      font-size: 16px;
      padding: 5px 0;
    }

    .resend-form {
      margin: 20px 0;
      text-align: center;
    }

    .resend-link {
      color: #3f79ff;
      font-size: 14px;
      background: none;
      border: none;
      padding: 0;
      cursor: pointer;
    }

    .resend-link:hover {
      text-decoration: underline;
    }

    .btn-custom {
      width: 100%;
      background-color: #3f79ff;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      font-weight: 500;
      border-radius: 12px;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #295fd4;
    }

    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 24px;
      color: #000;
      text-decoration: none;
      z-index: 10;
    }

    @media (max-width: 768px) {
      .container-custom {
        flex-direction: column;
      }

      .left-section,
      .right-section {
        flex: unset;
        width: 100%;
        padding: 20px;
        text-align: center;
      }

      .right-section {
        padding: 20px 30px;
      }

      .form-title {
        font-size: 28px;
      }

      .resend-form {
        text-align: center;
      }
    }
  </style>
</head>
<body>

  <a href="http://127.0.0.1:8000/login" class="back-button">
    <i class="fas fa-arrow-left"></i>
  </a>

  <div class="container-custom">
    <div class="left-section">
      <img src="http://127.0.0.1:8000/assets/images/forgot-password-illustration.png" alt="Security Image">
    </div>
    <div class="right-section">
        @if(session('otp_sent'))
          <div class="form-title">
            Verify<br>Your OTP
          </div>
          <form action="{{ route('verify.otp') }}" method="POST">
            @csrf
            <div class="input-wrapper">
              <i class="fas fa-envelope"></i>
              <input type="text" name="otp" placeholder="Enter Your OTP" required>
            </div>
            @if(session('error'))
              <div class="alert alert-danger py-2 text-center">
                {{ session('error') }}
              </div>
            @endif

            <!-- Resend OTP in center -->
            <div class="resend-form">
              <button type="button" class="resend-link" onclick="document.getElementById('resendForm').submit();">
                Resend OTP
              </button>
            </div>

            <button type="submit" class="btn btn-custom">Verify OTP</button>
          </form>
        @else
        <div class="form-title">
          Forget<br>Your Password
        </div>
        <form action="{{ route('send.otp') }}" method="POST">
            @csrf
            <div class="input-wrapper">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Enter Your Email" required>
            </div>
             @error('email')
              <div class="text-danger mb-3" style="margin-top: -10px;">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-custom">Send OTP</button>
          </form>
        @endif
    </div>
  </div>

  <!-- Hidden Resend OTP Form -->
 <form id="resendForm" action="{{ route('send.otp') }}" method="POST" >
    @csrf
    <input type="hidden" name="email" value="{{ session('email') }}">
  </form>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


