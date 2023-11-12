<?php

require_once("db.php");

function get_user_by_email($email)
{
    $connection = get_connection();

    $sql = "SELECT * FROM users WHERE email = ?";

    $statement = $connection->prepare($sql);

    $statement->bind_param("s", $email);

    $statement->execute();

    // Retrieve returned data from the database
    $result_set = $statement->get_result();

    if ($result_set->num_rows == 1) {
        return $result_set->fetch_assoc();
    }

    return null;
}

function create_user($name, $email, $password)
{
    $connection = get_connection();

    // SQL Query
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

    // Create prepared statement to be executed
    $statement = $connection->prepare($sql);

    $encoded_password = md5($password);
    // Bind the ? parameter to the corresponding data
    $statement->bind_param("sss", $name, $email, $encoded_password);

    // Execute statement
    $statement->execute();
}
