<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <?php
 
session_start();
 
if(isset($_GET['logout'])){    
    //Simple exit message
    date_default_timezone_set('UTC');
    $logout_message = "<div class='msgln'>⇒⇒ <span class='chat-time'>".date("Y-m-d H:i:s")."</span> ➥ <span class='left-info'><b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
    file_put_contents("log.html", base64_encode($logout_message), FILE_APPEND | LOCK_EX);
     
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        date_default_timezone_set('UTC');
        $join_message = "<div class='msgln'>⇒⇒ <span class='chat-time' style='color: green'>".date("Y-m-d H:i:s")."</span> ➥ <span class='join-info'><b class='user-name-join'>". $_SESSION['name'] ."</b> has joined the chat session.</span><br></div>";
        file_put_contents("log.html", base64_encode($join_message), FILE_APPEND | LOCK_EX);
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
 
function loginForm(){
    echo
    '<div id="loginform">
    <p>Please enter your name to continue!</p>
    <form action="index.php" method="post">
      <label for="name">Name &mdash;</label>
      <input type="text" name="name" id="name"  minlength="1" maxlength="32" title="Enter Name" required/>
      <input type="submit" name="enter" id="enter" value="Enter" title="Submit Name"/>
    </form>
  </div>';
}
 
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ChatBox v0.01</title>
        <meta name="title" content="Chatbox">
        <meta name="description" content="PHP based Chatbox from UltraStudioLTD -- version 0.01">
        <meta name="author" content="UltraStudioLTD">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
    <?php
    if(!isset($_SESSION['name'])){
        loginForm();
    }
    else {
    ?>
        <div id="wrapper">
            <div id="menu">
                <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
                <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
            </div>
 
            <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("log.html") > 0){
                $contents = file_get_contents("log.html");          
                echo base64_decode($contents);
            }
            ?>
            </div>
 
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>
        <footer>
            <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/">
                <img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/3.0/88x31.png" />
            </a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/">Creative Commons Attribution-NonCommercial 3.0 Unported License</a>.
        </footer>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });
 
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
 
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(atob(html)); //Insert chat log into the #chatbox div
 
                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }   
                        }
                    });
                }
 
                setInterval (loadLog, 2500);
 
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
                window.addEventListener('beforeunload', function (e) {
                    e.preventDefault();
                    e.returnValue = '';
                    window.location = "index.php?logout=true";
                });
            });
        </script>
    </body>
</html>
<?php
}
?> 
  </body>
</html>
