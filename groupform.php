<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style4.css"> 
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

      <a href="users.php" class="group-chat-button">Friend List</a> <!-- Add group chat button -->
    </header>
   
    <div class="users-list">
      <!-- User list will be populated dynamically by JavaScript -->
    </div>
    <div class="group-list">
      <h2>Group List</h2>
      <ul>
      <div class="wrapper">
  <section class="users">
    <header>
      <div class="content">



<!-- Add New Group Form -->
<div class="add-group-form">
  <h2>Add New Group</h2>
  <form action="add_group.php" method="POST">
    <input type="text" name="group_name" placeholder="Enter group name" required>
    <button type="submit">Create Group</button>
  </form>
</div>




       
      <!-- Display Existing Groups -->
<div class="group-list">
  <h2>Group List</h2>
  <ul>
    <?php
    $sql = "SELECT * FROM groups";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            // Wrap group name with anchor tag
            echo "<li><a href='groupchat2.php?group_id={$row['group_id']}'>{$row['group_name']}</a></li>";
        }
    } else {
        echo "<li>No groups found.</li>";
    }
    ?>
  </ul>
</div>

      
        <!-- Add more groups dynamically or fetch from database -->
      </ul>
    </div>
  </section>
</div>



<script src="javascript/groupusers.js"></script>

</body>
</html>
