<?php 
    // Connect to the database
    include_once "config.php";

    if(isset($_POST['messageId'])){
        $messageId = $_POST['messageId'];
        
        // Perform the deletion operation in your database using the provided messageId
        $sql = "DELETE FROM messages WHERE msg_id = $messageId";
        $query = mysqli_query($conn, $sql);
        
        if(!$query){
            // Deletion failed
            echo "Deletion failed: " . mysqli_error($conn);
            exit;
        } else {
            // Deletion successful
            echo "Message deleted successfully!";
        }
    } else {
        echo "Invalid request!";
    }
?>
