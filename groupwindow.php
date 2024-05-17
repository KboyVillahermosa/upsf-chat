<?php
session_start();
include_once "php/config.php";

// Check if user is logged in
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit;
}

// Check if selected_users are passed in the URL
if (!isset($_GET['selected_users'])) {
    header("location: users.php");
    exit;
}

// Get the group name
$groupName = isset($_POST['group_name']) ? $_POST['group_name'] : 'Group Chat';

// Extract selected users from URL
$selectedUsers = explode(',', $_GET['selected_users']);

// Get user details for selected users
$users = [];
foreach ($selectedUsers as $userId) {
    $userId = mysqli_real_escape_string($conn, $userId);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '$userId'");
    if ($query && mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        $users[] = $user;
    }
}

// Check if users are found
if (empty($users)) {
    echo "No users found.";
    exit;
}

// Create group chat ID
$groupChatId = uniqid();

// Store group chat ID in session
$_SESSION['group_chat_id'] = $groupChatId;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $groupName; ?></title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file here -->
    <style>
        /* Additional CSS styles */
        .user-list {
            padding: 20px;
        }

        .user-list h2 {
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

        .online {
            color: green;
        }

        .offline {
            color: red;
        }

        .chat-box {
            height: 300px; /* Adjust height as needed */
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <section class="users">
        <header>
            <div class="content">
                <?php
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                if (mysqli_num_rows($sql) > 0)  {
                    $row = mysqli_fetch_assoc($sql);
                }
                ?>
                <img src="php/images/<?php echo $row['img']; ?>" alt="">
                <div class="details">
                        <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
                        <p><?php echo $row['status']; ?></p>
            </div>
        </div>
        
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>"class="logout">Logout</a>

        <a href="users.php" class="group-chat-button">go back</a>
        </header>   

    <div class="wrapper">
        <section class="users">
            <header>
                <h2>Selected Users</h2>
            </header>
            <div class="user-list">
                <?php foreach ($users as $user): ?>
                    <div class="user-item">
                        <img src="php/images/<?php echo $user['img']; ?>" alt="Profile Picture">
                        <span><?php echo $user['fname'] . ' ' . $user['lname']; ?></span>
                        <?php echo ($user['status'] == 'Active') ? '<span class="online">Online</span>' : '<span class="offline">Offline</span>'; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Chatbox section -->
            <header>
                <h2><?php echo $groupName; ?></h2>
            </header>
            <div class="chat-box" id="chat-box">
                <!-- Messages will be loaded dynamically here -->
            </div>
            <form id="message-form" class="typing-area">
                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $groupChatId; ?>" hidden>
                <input type="text" name="message" id="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                <button type="submit">Send</button>
            </form>
        </section>
    </div>

    <script>
const form = document.getElementById('message-form');
const chatBox = document.getElementById('chat-box');
const groupChatId = "<?php echo $groupChatId; ?>"; // Retrieve groupChatId from PHP

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    formData.append('group_chat_id', groupChatId); // Append groupChatId to the form data
    const response = await fetch('send_message.php', {
        method: 'POST',
        body: formData
    });
    const data = await response.text();
    chatBox.innerHTML += data;
    chatBox.scrollTop = chatBox.scrollHeight;
    form.reset();
});

// Function to periodically update the chat messages
async function updateChat() {
    const response = await fetch(`get_messages.php?group_chat_id=${groupChatId}`); // Pass groupChatId in the URL
    const data = await response.text();
    chatBox.innerHTML = data;
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Update chat messages every 5 seconds
setInterval(updateChat, 5000);
updateChat(); // Initial call to update messages

</script>
</body>
</html>
