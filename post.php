<?php
session_start();
if(isset($_SESSION['name'])){
    date_default_timezone_set('UTC');
    if(isset($_POST['text'])){
        $text = $_POST['text'];
    };
    $text_message = "<div class='msgln'>⇒⇒ <span class='chat-time' style='color: gold'>".date("Y-m-d H:i:s")."</span> ➥ <b class='user-name' style='font-weight: bold; background: black; color: gold; padding: 2px 4px; font-size: 90%; border-radius: 4px; margin: 0 5px 0 0;'>".$_SESSION['name']."</b color='cyan'> ".stripslashes(htmlspecialchars($text))."<br></div>";
    file_put_contents("log.html", base64_encode($text_message), FILE_APPEND | LOCK_EX);
}
?>
