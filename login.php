<?php
require('includes/db.inc.php');
require('includes/function.php');
if (isset($_SESSION['isUserLoggedIn']) && $_SESSION['isUserLoggedIn']) {
  redirect('index.php');
}

if (isset($_POST['login'])) {
  $email = $conn->real_escape_string($_POST['email']);
  $password = $conn->real_escape_string($_POST['password']);

  $query = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
  $runQuery = $conn->query($query);
  if ($runQuery->num_rows != 0) {
    $_SESSION['isUserLoggedIn'] = true;
    $_SESSION['email'] = $email;
    redirect('index.php?page=1');
  } else {
    echo "<script>alert('Incorrect email or password!');</script>";
  }
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blogbook - Sign In</title>
  <link rel="icon" href="images/icon.jpg" type="image/x-icon">
  <link href="styles/style.css" rel="stylesheet">
  <style>
    :root {
      --main-bg: white;
    }

    .main-bg {
      background: var(--main-bg) !important;
    }

    input:focus,
    button:focus {
      border: 1px solid var(--main-bg) !important;
      box-shadow: none !important;
    }

    .form-check-input:checked {
      background-color: var(--main-bg) !important;
      border-color: var(--main-bg) !important;
    }

    .card,
    .btn,
    input {
      border-radius: 0 !important;
    }
  </style>
</head>

<body class="main-bg">
  <!-- Login Form -->
  <div class="container" style="margin: auto">
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h1 class="p-3"><a href="index.php" style="text-decoration: none; color: black">BLOGBOOK</a></h1>
            <p style="font-weight: bold">Login to Blogbook</p>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="mb-4">
                <label for="username" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required/>
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required/>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-dark" name="login">Login</button>
              </div>
              <div class="mb-4" style="margin-top: 10px">
                <p style="display: inline-block;">Need an account? </p>
                <a href="./register.php">Create Account</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>