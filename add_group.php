<?php
session_start();
include_once "php/config.php";

if(isset($_POST['group_name'])){
    $group_name = mysqli_real_escape_string($conn, $_POST['group_name']);

    // Insert the new group into the database
    $sql = "INSERT INTO groups (group_name) VALUES ('$group_name')";
    $query = mysqli_query($conn, $sql);

    if($query){
        echo "Group created successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>