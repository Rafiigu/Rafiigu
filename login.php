<?php

session_start();
require_once("users.php");
require_once("auth.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Cek apakah email user exist di database
  // Jika exist cek passwordnya, apakah inputnya benar atau tidak.
  $email = $_POST["email"];
  $password = $_POST["password"];

  $user = get_user_by_email($email);

  if ($user) {
    if (md5($password) == $user["password"]) {
      $cookie_value = $user["id"] . "#" . $user["email"];
      setcookie(
        name: "SIMPLE_REMINDER_LOGIN_SESSION",
        value: $cookie_value,
        expires_or_options: (time() + 60 * 60),
        path: "/",
        secure: true,
        httponly: true
      );

      header("Location: ./home.php");
    } else {
      $_SESSION["LOGIN_ERROR_MESSAGE"] = "Email or password is incorrect";
      header("Location: ./login.php");
    }
  } else {
    $_SESSION["LOGIN_ERROR_MESSAGE"] = "Email or password is incorrect";
    header("Location: ./login.php");
  }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (is_login_cookie_valid() == true) {
    header("Location: ./home.php");
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@10..48,200;10..48,300;10..48,400;10..48,500;10..48,600;10..48,700;10..48,800&display=swap" rel="stylesheet">
    <link href="./index.css" rel="stylesheet">
    <title>Simple Reminder | Login</title>
  </head>

  <body>
    <header class="header" style="justify-content: center; padding-top: 20px;">
      <a>
        <h1 class="brand">Simple Todo</h1>
      </a>
    </header>
    <form method="POST" action="./login.php" class="input-form" style="margin-top: 20px">
      <div class="input-group">
        <label>Email</label>
        <input name="email" type="email" required />
        <?php
        if (isset($_SESSION["LOGIN_ERROR_MESSAGE"])) {
        ?>
          <p class="input-error"><?= $_SESSION["LOGIN_ERROR_MESSAGE"] ?></p>
        <?php
        }
        ?>
      </div>
      <div class="input-group">
        <label>Password</label>
        <input name="password" type="password" required />
        <?php
        if (isset($_SESSION["LOGIN_ERROR_MESSAGE"])) {
        ?>
          <p class="input-error"><?= $_SESSION["LOGIN_ERROR_MESSAGE"] ?></p>
        <?php
        }
        ?>
      </div>
      <div class="input-group" style="margin-top: 16px;">
        <button class="button-primary" type="submit">Login</button>
      </div>
    </form>
  </body>

  </html>
<?php
  session_unset();
} ?>