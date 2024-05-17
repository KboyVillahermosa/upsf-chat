<?php
// Perform a query to get the initial data
$initial_query = mysqli_query($conn, "SELECT * FROM users");

$output = "";
while ($row = mysqli_fetch_assoc($initial_query)) {
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);

    if ($query2) {
        $row2 = mysqli_fetch_assoc($query2);
        $result = (mysqli_num_rows($query2) > 0) ? $row2['msg'] : "No message available";
        $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;

        // Bad word filter logic
        $badWords = array("bogo", "bitch", "rude", "yawa","piste","fuck","pakyu","kayata","boang","ulok","pussy","bilat","amputa","animal ka","bilat","binibrocha","bobo","bogo","boto","brocha","burat","bwesit","bwisit","demonyo ka","engot","etits","gaga","gagi","gago","habal","hayop ka","hayup","hinampak","hinayupak","hindot","hindutan","hudas","iniyot","inutel","inutil","iyot","kagaguhan","kagang","kantot","kantotan","kantut","kantutan","kaululan","kayat","kiki","kikinginamo","kingina","kupal","leche","leching","lechugas","lintik","nakakaburat","nimal","ogag","olok","pakingshet","pakshet","pakyu","pesteng yawa","poke","poki","pokpok","poyet","pu'keng","pucha","puchanggala","puchangina","puke","puki","pukinangina","puking","punyeta","puta","putang","putang ina","putangina","putanginamo","putaragis","putragis","puyet","ratbu","shunga","sira ulo","siraulo","suso","susu","tae","taena","tamod","tanga","tangina","taragis","tarantado","tete","teti","timang","tinil","tite","titi","tungaw","ulol","ulul","ungas","potanginamo"); // Replace with your bad words array
        foreach ($badWords as $word) {
            if (stripos($msg, $word) !== false) {
                // If bad word found, mute the message
                $msg = "This message has been muted due to inappropriate content";
                break; // No need to continue checking for other bad words
            }
        }

        if (isset($row2['outgoing_msg_id'])) {
            $you = ($outgoing_id == $row2['outgoing_msg_id']) ? "You: " : "";
        } else {
            $you = "";
        }
    } else {
        // Handle the case where the query2 fails
        $msg = "No message available";
        $you = "";
    }

    $offline = ($row['status'] == "Offline now") ? "offline" : "";
    $hid_me = ($outgoing_id == $row['unique_id']) ? "hide" : "";

    // Only display user details if not the logged-in user
    if ($hid_me !== "hide") {
        $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                    <img src="php/images/' . $row['img'] . '" alt="">
                    <div class="details">
                        <span>' . $row['fname'] . " " . $row['lname'] . '</span>
                        <p>' . $you . htmlspecialchars($msg) . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
    }
}
?>
