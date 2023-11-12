<?php

require_once("users.php");

function is_login_cookie_valid()
{
  // Jika cookie dengan nama SIMPLE_REMINDER_LOGIN_SESSION tidak ada di browser, maka cookie tidak valid
  if (isset($_COOKIE["SIMPLE_REMINDER_LOGIN_SESSION"]) == false) {
    return false;
  } else {
    $cookie_value = $_COOKIE["SIMPLE_REMINDER_LOGIN_SESSION"];
    $cookie_value = explode("#", $cookie_value);

    // id user yang tersimpan di dalam cookie
    $user_id = $cookie_value[0];

    // email user yang tersimpan di dalam cookie
    $user_email = $cookie_value[1];

    // lakukan get (select) ke database table user dengan email yang tersimpan di dalam cookie
    // Jika email yang tersimpan di dalam cookie terdaftar sebagai email salah satu user
    // yang tersimpan di dalam database, maka function ini akan mengembalikan seluruh detail dari 
    // user dengan email tersebut.
    // Jika email tidak ada, maka return dari function adalah null.
    $user = get_user_by_email($user_email);

    if ($user == null) {
      return false;
    }

    if ($user_id != $user["id"]) {
      return false;
    }
  }

  return true;
}

function get_auth_user(){
  if(is_login_cookie_valid() == true){
    $cookie_value = $_COOKIE["SIMPLE_REMINDER_LOGIN_SESSION"];
    $cookie_value = explode("#", $cookie_value);

    $user_id = $cookie_value[0];
    $user_email = $cookie_value[1];
    $user = get_user_by_email($user_email);

    return $user;
  }
  return null;
}
