<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style4.css"> 
  <style>
    .user-list img {
      max-width: 50px; /* Set maximum width */
      max-height: 50px; /* Set maximum height */
    }
  </style>
</head>
<body>

<?php 
session_start();
include_once "php/config.php";
if(!isset($_SESSION['unique_id'])){
  header("location: login.php");
}
include_once "header.php";
?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $group_id = mysqli_real_escape_string($conn, $_GET['group_id']);
          $sql = mysqli_query($conn, "SELECT * FROM groups WHERE group_id = {$group_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: groupchat.php");
          }
        ?>
        <a href="groupchat.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        
        <div class="details">
          <span><?php echo $row['group_name']; ?></span>
          <!-- Add additional group details here if needed -->
        </div>
      </header>
      <div class="user-list">
        <h2>Users</h2>
        <ul>
          <?php
            // Fetch users from the database
            $users_query = mysqli_query($conn, "SELECT * FROM users");
            while ($user = mysqli_fetch_assoc($users_query)) {
              // Display each user with their image
              echo "<li><img src='php/images/{$user['img']}' alt='{$user['fname']} {$user['lname']}'><span>{$user['fname']} {$user['lname']}</span><form method='POST' action='#'><input type='hidden' name='user_id' value='{$user['unique_id']}'><button type='submit'>Add</button></form></li>";
            }
          ?>
        </ul>
      </div>
      <div class="chat-box">
        <!-- Display group messages here -->
      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $group_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>
</html>