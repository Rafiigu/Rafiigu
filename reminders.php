<?php

date_default_timezone_set('Asia/Jakarta');

require_once("db.php");

function create_reminder($title, $description, $time, $user_id){
    $connection = get_connection();
    $sql = "INSERT INTO reminder(title, description, time, user_id) VALUES (?, ?, ?, ?)";
    $statement = $connection->prepare($sql);
    $statement->bind_param("sssd", $title, $description, $time, $user_id);
    return $statement->execute();
}

function update_reminder($id, $title, $description, $time){
    $connection = get_connection();
    $sql = "UPDATE reminder SET title = ?, description = ?, time = ? WHERE id = ?";
    $statement = $connection->prepare($sql);
    $statement->bind_param("sssd", $title, $description, $time, $id);
    return $statement->execute();
}

//create_reminder("Makan Ikan Tongkol", "Mangan", date("Y-m-d H:i:s"), 6);

// Get reminder by user id
function get_reminders($user_id){
    $connection = get_connection();

    $sql = "SELECT * FROM reminder WHERE user_id = ?";
    $statement = $connection->prepare($sql);
    $statement->bind_param("d", $user_id);
    $statement->execute();

    $result_set = $statement->get_result();
    $reminders = [];

    while($row = $result_set->fetch_assoc()){
        array_push($reminders, $row);
    }

    return $reminders;
}

// Get reminder by reminder id
function get_reminder($id){
    $connection = get_connection();
    $sql = "SELECT * FROM reminder WHERE id = ?";
    $statement = $connection->prepare($sql);
    $statement->bind_param("d", $id);
    $statement->execute();

    $result_set = $statement->get_result();
    return $result_set->fetch_assoc();
}

function delete_reminder($id){
    $connection = get_connection();
    $sql = "DELETE FROM reminder WHERE id = ?";
    $statement = $connection->prepare($sql);
    $statement->bind_param("d", $id);
    return $statement->execute();
}

?>