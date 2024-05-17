<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT * FROM messages 
                LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
                ORDER BY msg_id";
        $query = mysqli_query($conn, $sql);
        
        if(!$query){
            // Query failed, display the error
            echo "Query failed: " . mysqli_error($conn);
            exit;
        }

        // Example array of bad words
        $badWords = array("bogo", "bitch", "rude", "yawa","piste","fuck","pakyu","kayata","boang","ulok","pussy","bilat","amputa","animal ka","bilat","binibrocha","bobo","bogo","boto","brocha","burat","bwesit","bwisit","demonyo ka","engot","etits","gaga","gagi","gago","habal","hayop ka","hayup","hinampak","hinayupak","hindot","hindutan","hudas","iniyot","inutel","inutil","iyot","kagaguhan","kagang","kantot","kantotan","kantut","kantutan","kaululan","kayat","kiki","kikinginamo","kingina","kupal","leche","leching","lechugas","lintik","nakakaburat","nimal","ogag","olok","pakingshet","pakshet","pakyu","pesteng yawa","poke","poki","pokpok","poyet","pu'keng","pucha","puchanggala","puchangina","puke","puki","pukinangina","puking","punyeta","puta","putang","putang ina","putangina","putanginamo","putaragis","putragis","puyet","ratbu","shunga","sira ulo","siraulo","suso","susu","tae","taena","tamod","tanga","tangina","taragis","tarantado","tete","teti","timang","tinil","tite","titi","tungaw","ulol","ulul","ungas","potanginamo");

        // Function to filter bad words
        function filterBadWords($message, $badWords) {
            foreach ($badWords as $word) {
                $replaceWith = str_repeat('*', strlen($word));
                $message = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', $replaceWith, $message);
            }
            return $message;
        }

        // Check if there are rows returned
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                $filteredMessage = filterBadWords($row['msg'], $badWords);
                
                if($row['outgoing_msg_id'] === $outgoing_id){
                    // Display outgoing message
                    $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>'. $filteredMessage .'</p>
                                    </div>
                                </div>';
                } else {
                    // Display incoming message with sender's profile picture
                    $imgSrcSender = isset($row['img']) ? 'php/images/'.$row['img'] : ''; // Fetch profile picture for sender
                    $imageTagSender = $imgSrcSender ? '<img src="' . $imgSrcSender . '" alt="">' : ''; // Profile picture HTML for sender
                    $output .= '<div class="chat incoming">' . $imageTagSender . '
                                    <div class="details">
                                        <p>'. $filteredMessage .'</p>
                                    </div>
                                </div>';
                }
            }
        } else {
            $output .= '<div class="text">No messages are available. Once you send a message, it will appear here.</div>';
        }
        echo $output;
    } else {
        header("location: ../login.php");
    }
?>
