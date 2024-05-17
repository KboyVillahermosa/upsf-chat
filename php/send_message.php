<?php
session_start();
include_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['unique_id']) && isset($_POST['group_chat_id']) && isset($_POST['message'])) {
        $groupChatId = mysqli_real_escape_string($conn, $_POST['group_chat_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $senderId = $_SESSION['unique_id'];

        // Insert message into database
        $query = "INSERT INTO group_messages (group_chat_id, sender_id, message, sent_at) VALUES ('$groupChatId', '$senderId', '$message', NOW())";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Return the newly inserted message HTML
            $senderName = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
            echo "<div><strong>$senderName:</strong> $message</div>";
            exit;
        } else {
            echo "Failed to send message.";
            exit;
        }
    } else {
        echo "Invalid request.";
        exit;
    }
} else {
    echo "Method not allowed.";
    exit;
}
?>