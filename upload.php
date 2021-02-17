<?php

session_start();

if(isset($_SESSION['name'])){

    date_default_timezone_set('UTC');

    if(!isset($_FILES['my_file']) and ($_FILES['my_file']['name']=="")){

        return null;

    };

    $target_dir = "upload/";
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file = $_FILES['my_file']['name'];

    $path = pathinfo($file);

    $filename = $path['filename'];

    $ext = $path['extension'];

    $temp_name = $_FILES['my_file']['tmp_name'];

    $file_name = $_FILES['my_file']['name'];

    $file_size = $_FILES['my_file']['size'];

    $file_type = $_FILES['my_file']['type'];

    $path_filename_ext = $target_dir.$filename.".".$ext;

 

    // Check if file already exists

    if (file_exists($path_filename_ext)) {

        $path_filename_ext = $target_dir.$filename." (".implode('', explode('.', date('YmdHis'.substr((string)microtime(), 1, 8).''))).").".$ext;

        move_uploaded_file($temp_name,$path_filename_ext);

        $file_message = "<div class='msgln'><span class='chat-time' style='background-color: black; color: gold'>".date("Y-m-d H:i:s")."</span> ➥ <b class='user-name' style='font-weight: bold; background: black; color: yellow; padding: 2px 4px; font-size: 90%; border-radius: 4px; margin: 0 5px 0 0;'>".$_SESSION['name']."</b><img src='".$path_filename_ext."'/></div>";

        file_put_contents("log.html", $file_message, FILE_APPEND | LOCK_EX);

    } else {

        move_uploaded_file($temp_name,$path_filename_ext);

        $file_message = "<div class='msgln'><span class='chat-time' style='background-color: black; color: gold'>".date("Y-m-d H:i:s")."</span> ➥ <b class='user-name' style='font-weight: bold; background: black; color: yellow; padding: 2px 4px; font-size: 90%; border-radius: 4px; margin: 0 5px 0 0;'>".$_SESSION['name']."</b><img src='".$path_filename_ext."'/></div>";

        file_put_contents("log.html", $file_message, FILE_APPEND | LOCK_EX);

    };

    header("Location: index.php");

}

?>
