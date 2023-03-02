<?php
session_start();
include('CAPTCHA.php');

if ($_POST['captcha'] == $_SESSION['captcha']) {
    // The CAPTCHA was entered correctly
    echo "CAPTCHA was entered correctly.";
} else {
    // The CAPTCHA was not entered correctly
    echo "CAPTCHA was not entered correctly.";
}
?>
