<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style4.css"> 
  <style>



    
    
    .group-chat-button {
      display: block;
      width: 100%;
      text-align: center;
      padding: 10px 0;
      background-color: #0078FF;
      color: #fff;
      text-decoration: none;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .group-chat-button:hover {
      background-color: #0056b3;
    }
  
    .users-list {
      max-height: 300px; /* Adjust the maximum height as needed */
      overflow-y: auto; /* Enable vertical scrollbar if content exceeds the container height */
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
?>

<div class="wrapper">
  <section class="users">
    <header>
      <div class="content">
        <?php 
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }
        ?>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </div>
      <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
      
      <a href="groupchat.php" class="group-chat-button">Group Chat</a> <!-- Add group chat button -->
    </header>
    <div class="search">
      <span class="text">Select a user to start chat</span>
      <input type="text" placeholder="Enter name to search...">
      <button><i class="fas fa-search"></i></button>
    </div>
    <div class="users-list">
      <!-- User list will be populated dynamically by JavaScript -->
    </div>
  </section>
</div>

<script src="javascript/users.js"></script>

</body>
</html>