<?php
session_start(['name' => 'IN']);

$image = imageCreate(200, 100);

$white = imageColorAllocate($image, 255, 255, 255);
$black = imageColorAllocate($image, 0, 0, 0);

imageString($image, 5, 80, 40, $_SESSION['capt'], $black);

header("Content-type: image/png");
imagepng($image);
imagedestroy($image);