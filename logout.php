<?php

require_once("auth.php");

if (is_login_cookie_valid() == true){
    setcookie(
        name: "SIMPLE_REMINDER_LOGIN_SESSION",
        value: $cookie_value,
        expires_or_options: (time() - time()),
        path: "/",
        secure: true,
        httponly: true
      );
}
header("Location: ./login.php");

?>