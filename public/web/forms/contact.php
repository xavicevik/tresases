<?php

$to = "info@adamm.com.co";
$subject = $_POST['subject'];
$message = $_POST['message'];
$from = $_POST['name'];
$headers = $_POST['email'];

mail($to,$subject,$message,$headers);

header("Location:" . $_SERVER['HTTP_REFERER']);