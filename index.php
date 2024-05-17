<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
</head>
<body>

<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<div class="container">
    <div class="left-section">
        <div class="header">
            <!-- Your logo within the left section -->
            <img class="logo" src="uspflogols.png" alt="Logo">
            <div class="welcome-message">
                <p class="bold">Join Uspians! 👋</p>
                <p>Let's build a community together!</p>
            </div>
        </div>

  <div class="form">
    <section class="form signup">
     
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="name-details">
          <div class="field input">
            <label></label>
            <input type="text" name="fname"  placeholder="First name" required>
          </div>
          <div class="field input">
            <label></label>
            <input type="text" name="lname" placeholder="Last name" required>
          </div>
        </div>
        <div class="field input">
          <label></label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label></label>
          <input type="password" name="password" placeholder="Enter new password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field image">
          <label></label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>

      <div class="signup-link">
      <div class="link">Already signed up? <a href="login.php">Login now</a></div>
    </section>
  </div>

  
  
 

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/signup.js"></script>

</body>
</html>
