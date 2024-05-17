<?php
session_start();
include_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['group_chat_id'])) {
    $groupChatId = $_GET['group_chat_id'];

    $query = "SELECT * FROM group_chat_messages WHERE group_chat_id = '$groupChatId' ORDER BY created_at ASC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $message = $row['message'];
            $senderId = $row['sender_id'];
            $class = ($senderId == $_SESSION['unique_id']) ? "outgoing" : "incoming";

            echo '<div class="message ' . $class . '">
                    <p>' . $message . '</p>
                  </div>';
        }
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
