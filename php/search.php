<?php
session_start();
include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%')";
$output = "";

$query = mysqli_query($conn, $sql);
if ($query && mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $status = ($row['status'] == "Offline now") ? "offline" : "";
        // You can adjust the message displayed for each user
        $message = "Search results for '" . $searchTerm . "'";

        $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                        <div class="content">
                            <img src="php/images/' . $row['img'] . '" alt="">
                            <div class="details">
                                <span>' . $row['fname'] . " " . $row['lname'] . '</span>
                                <p>' . $message . '</p>
                            </div>
                        </div>
                        <div class="status-dot ' . $status . '"><i class="fas fa-circle"></i></div>
                    </a>';
    }
} else {
    $output .= 'No user found related to your search term';
}

echo $output;
?>
