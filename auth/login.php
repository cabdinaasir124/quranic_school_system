<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Qur'anic School</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f0f2f5;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      width: 100%;
      max-width: 800px;
      background: #fff;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
    }

    .login-left, .login-right {
      flex: 1 1 50%;
      padding: 30px;
    }

    .login-left {
      background: url('../assets/img/arday_abuu.jpg') no-repeat center center;
      background-size: cover;
      position: relative;
    }

    /* .login-left::before {
      content: "";
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.6);
    } */

    .login-left-content {
      position: relative;
      color: white;
      z-index: 2;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
    }

    .login-left-content h2 {
      font-weight: bold;
    }

    .login-right {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-logo {
      width: 80px;
      margin: 0 auto 20px;
    }

    .form-control, .btn-primary {
      border-radius: 0.5rem;
    }

    @media (max-width: 767px) {
      .login-left {
        display: none;
      }
      .login-right {
        flex: 1 1 100%;
      }
    }
  </style>
</head>
<body>

<div class="login-container">
  
  <!-- Left Side -->
  <div class="login-left">
    <div class="login-left-content">
      <!-- <h2>Welcome to Dugsikaal</h2>
      <p>Learn. Grow. Memorize Qur'an.</p> -->
    </div>
  </div>

  <!-- Right Side -->
  <div class="login-right">
    <div class="text-center">
      <img src="../assets/img/abuu musa al ashcari.jpg" alt="Logo" class="login-logo rounded-circle shadow-sm">
    </div>
    <h4 class="text-center mb-4">Abuu musal ashcari</h4>
    <!-- <div class="alert alert-danger"></div> -->
   <form action="login.php" method="POST" autocomplete="off">
  <div class="mb-3">
    <label for="username" class="form-label">Username or Email</label>
    <input type="text" class="form-control" id="username" name="username" autocomplete="off" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label d-flex justify-content-between">
      <span>Password</span>
      <a href="#" class="text-decoration-none" style="font-size: 0.9rem;">Forgot?</a>
    </label>
    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
  </div>
  <div class="d-grid">
    <button type="submit" name="loginSubmit" class="btn btn-primary">Login</button>
  </div>
</form>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
