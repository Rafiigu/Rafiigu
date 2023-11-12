<?php

session_start();
require_once("./users.php");
require_once("./auth.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $full_name = $_POST["fullname"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Cek apakah email sudah terdaftar pada database atau belum.
  $user = get_user_by_email($email);

  // Jika email belum terdaftar.
  if ($user == null) {
    create_user($full_name, $email, $password);
    header("Location: ./home.php");
  } else {
    // Email telah terdaftar
    $_SESSION["EMAIL_EXIST_ERROR"] = "Email has been registered";
    header("Location: ./register.php");
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
    <title>Simple Reminder | Register</title>
  </head>

  <body>
    <header class="header">
      <a>
        <h1 class="brand">Simple Todo</h1>
      </a>
    </header>
    <form method="POST" action="./register.php" class="input-form" style="margin-top: 120px">

      <div class="input-group">
        <label>Fullname</label>
        <input name="fullname" type="text" required />
      </div>

      <div class="input-group">
        <label>Email</label>
        <input name="email" type="email" required />
        <?php
        if (isset($_SESSION["EMAIL_EXIST_ERROR"])) {
        ?>
          <p class="input-error"><?= $_SESSION["EMAIL_EXIST_ERROR"] ?></p>
        <?php
        } ?>
      </div>
      <div class="input-group">
        <label>Password</label>
        <input name="password" type="password" required />
      </div>
      <div class="input-group" style="margin-top: 16px;">
        <button class="button-primary" type="submit">Register</button>
      </div>
    </form>
  </body>

  </html>
<?php
  session_destroy();
} ?>