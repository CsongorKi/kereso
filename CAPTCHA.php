<?php
session_start();
//include('urlap.php');

$width = 200;
$height = 60;
$characters = 6;

// Generate a random string for the CAPTCHA
$captcha = substr(md5(rand()), 0, $characters);

// Save the CAPTCHA string in the session
$_SESSION['captcha'] = $captcha;

// Create a new image with the given dimensions
$image = imagecreatetruecolor($width, $height);

// Set the background color of the image to white
$bg_color = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bg_color);

// Generate random lines on the image to make it harder to read
for ($i = 0; $i < 5; $i++) {
    $line_color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// Write the CAPTCHA string on the image
$text_color = imagecolorallocate($image, 0, 0, 0);
$text_x = rand(10, $width - $characters * 20);
$text_y = rand(10, $height - 20);
imagestring($image, 5, $text_x, $text_y, $captcha, $text_color);

// Output the image as PNG
header('Content-Type: image/png');
imagepng($image);

// Free up memory
imagedestroy($image);
include('check-captcha.php');
?>


<form method="post" action="checkcaptcha.php">
    <label for="captcha">Please enter the CAPTCHA:</label>
    <br>
    <img src="captcha.php" alt="CAPTCHA">
    <br>
    <input type="text" id="captcha" name="captcha">
    <br>
    <input type="submit" value="Submit">
</form>
