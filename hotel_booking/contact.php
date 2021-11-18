<?php
    if($_SERVER["REQUEST_METHOD"] == 'POST'){ // Check if the User coming from a request
        $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING); // simple validation if you insert a string

        // mail funciton in php look like this (mail(To, Subject, Message, Headers, Parameters))
        $headers = "FROM : ". $email . "\r\n";
        $myEmail = "unilyang@gmail.com";
        if(mail($myEmail, "message coming from the contact form", $msg, $headers)){
            echo "sent";
        }else {
                echo "error";
        }
    }
?>
