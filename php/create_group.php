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
            <a href="groupchat.php" class="group-chat-button">Group Chat</a>
        </header>

        <div class="users-list">
            <!-- User list will be populated dynamically by JavaScript -->
        </div>

        <div class="group-list">
            <h2>Group List</h2>
            <ul>
                <?php
                    // Fetch groups from database
                    $group_sql = "SELECT * FROM groups";
                    $group_result = mysqli_query($conn, $group_sql);
                    if(mysqli_num_rows($group_result) > 0){
                        while($group_row = mysqli_fetch_assoc($group_result)){
                            echo "<li>" . $group_row['group_name'] . "</li>";
                        }
                    } else {
                        echo "<li>No groups found</li>";
                    }
                ?>
            </ul>
        </div>

        <div class="group-form">
            <h2>Create New Group</h2>
            <form action="create_group.php" method="POST">
                <input type="text" name="group_name" placeholder="Enter group name" required>
                <button type="submit">Create Group</button>
            </form>
        </div>
    </section>
</div>