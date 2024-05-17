<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style2.css"> 
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
                <p class="bold">Welcome Uspians!👋</p>
                <p>Sparking Discussions, Fueling Knowledge!</p>
            </div>
        </div>

        <div class="wrapper">
            <section class="form login">
               
                <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="error-text"></div>
                    <div class="field input">
                        <label>Email Address</label>
                        <input type="text" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="field input">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="field button">
                        <input type="submit"  name="submit" value="Sign In">
                    </div>
                </form>

                <div class="signup-link">
                    <p>Don't have an account? <a href="index.php" class="sign-up-button">Sign up</a></p>
                </div>
            </section>
        </div>
    </div>

    <div class="right-section">
        <!-- Your image or content for the right section -->
        <div class="image-container">
            <img src="rodjie_update.jpg" alt="Amazing Image">
        </div>
    </div>
</div>

<script src="javascript/pass-show-hide.js"></script>
<script src="javascript/login.js"></script>
</body>
</html>