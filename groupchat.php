<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css"> <!-- Add your CSS file here -->
  <style>
    /* Additional CSS styles */

    .join-chat-button:hover {
      background-color: #2E8B57; /* Darker green color on hover */
    }

    .users-list {
      padding: 20px;
    }
    .users-list h2 {
      font-size: 1.2rem;
      margin-bottom: 10px;
    }
    .user-item {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }
    .user-item img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 10px;
    }
    .user-item label {
      cursor: pointer;
    }
    .user-item input[type="checkbox"] {
      margin-right: 5px;
    }
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

      <a href="#" class="group-chat-button" id="createGroupButton">Create Group</a> <!-- Add group chat button -->
    </header>
   
    <div class="users-list">
      <h2>Select users to create a group chat:</h2>
      <form action="groupwindow.php" method="POST" id="groupForm">
        <?php
          $users_query = mysqli_query($conn, "SELECT * FROM users WHERE unique_id != {$_SESSION['unique_id']}");
          while ($user = mysqli_fetch_assoc($users_query)) {
            // Display each user with a profile picture and a checkbox
            echo "<div class='user-item'>";
            echo "<img src='php/images/{$user['img']}' alt='Profile Picture'>";
            echo "<label>";
            echo "<input type='checkbox' name='selected_users[]' value='{$user['unique_id']}' id='user{$user['unique_id']}'>";
            echo "{$user['fname']} {$user['lname']}";
            echo "</label>";
            echo "</div>";
          }
        ?>
        <input type="text" name="group_name" placeholder="Enter group name" required>
        
        <button id="join-chat-btn" class="join-chat-button">Join Chat</button> <!-- Join Chat button -->
    </header>

      </form>
    </div>
  </section>
</div>

<script>
  const createGroupButton = document.getElementById('createGroupButton');
  createGroupButton.addEventListener('click', function() {
    const checkedUsers = document.querySelectorAll('input[name="selected_users[]"]:checked');
    if (checkedUsers.length < 2) {
      alert('Please select at least two users to create a group chat.');
      return;
    }
    // Construct the group chat URL based on selected users
    let url = 'groupwindow.php?selected_users=';
    checkedUsers.forEach((user, index) => {
      if (index !== 0) {
        url += ',';
      }
      url += user.value;
    });
    // Redirect to the group chat page
    window.location.href = url;
  });
</script>

</body>
</html>
