<?php
header('Content-Type: image/png');
$image = imagecreatetruecolor(100, 100);
$color = imagecolorallocate($image, 255, 0, 0);  // Red
imagefilledrectangle($image, 0, 0, 100, 100, $color);
imagepng($image);
imagedestroy($image);
?>
