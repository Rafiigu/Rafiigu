<?php

require_once("users.php");
require_once("auth.php");
require_once("reminders.php");

if (is_login_cookie_valid() == false) {
  header("Location: ./login.php");
}

$auth_user = get_auth_user();
$reminders = get_reminders($auth_user["id"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <title>Home</title>
</head>

<body>
  <header class="header" style="justify-content: space-between; padding: 12px 0px;">
    <a href="./home.php" style="margin-left: 16px; text-decoration: none;">
      <h1 class="brand">Simple Todo</h1>
    </a>
    <div style="display: flex; flex-direction: row; align-items: center;">
      <p style="margin-right: 16px;">Hello, <?= $auth_user["name"] ?></p>
      <a href="./logout.php" style="margin-right: 16px;"><button class="button-secondary">Logout</button></a>
    </div>
  </header>
  <button style="margin-bottom: 25px; background-color: #2e5ba5;" class="button-primary"><a style="display:block; text-decoration: none; margin-left: auto; color: white" href="./reminder/create.php">Create</a></button>
  <div>
    <?php
    
    foreach($reminders as $i => $reminder){
      ?>

      <div style="display: flex; flex-direction: column; padding: 16px; background-color: #2e5ba5;; box-shadow: 0 2px 8px #dcdcdc; min-width: 320px; border-radius: 12px; position: sticky; margin-bottom: 20px; max-width: 320px">
        <h2 style="color: white; margin-bottom: 4px">Title: <span style="font-weight: 600;"><?= $reminder["title"] ?></span></h2>
        <h2 style="color: white; margin-bottom: 4px">Description: <span style="font-weight: 500;"><?= $reminder["description"] ?></span></h2>
        <h2 style="color: white; margin-bottom: 4px">Deadline: <span style="font-weight: 600;"><?= $reminder["time"] ?></span></h2>
        <div style="display: flex; flex-direction: row; justify-content: space-around; margin-top: 10px;">
        <a href="./reminder/delete.php?id=<?= $reminder['id'] ?>" class="button-primary" style = "display:block; text-decoration: none; color: white; margin-left: auto; font-weight: 700;">Delete Reminder</a>
        <a href="./reminder/update.php?id=<?= $reminder['id'] ?>" class="button-primary" style = "display:block; text-decoration: none; color: white; margin-left: auto; font-weight: 700;">Update Reminder</a>
        </div>
      </div>

    <?php } ?>

    
  </div>

</body>

</html>