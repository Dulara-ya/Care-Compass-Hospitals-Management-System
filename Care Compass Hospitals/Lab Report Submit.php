<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "hospital_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['nic'];
    $report_date = $_POST['report_date'];
    $report_file = $_FILES['report_file']['name'];
    $report_file_tmp = $_FILES['report_file']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($report_file);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    $allowed_types = array('pdf', 'jpg', 'jpeg', 'png');
    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($report_file_tmp, $target_file)) {
            $sql = "INSERT INTO lab_reports (nic, report_date, report_file) VALUES ('$nic', '$report_date', '$report_file')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('success', 'Lab report uploaded successfully!');
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('error', 'Error: " . $conn->error . "');
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('error', 'Sorry, there was an error uploading your file.');
                });
            </script>";
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('error', 'Invalid file type. Only PDF, JPG, and PNG files are allowed.');
            });
        </script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospitals</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #1976D2;
            --primary-light: #BBDEFB;
            --primary-dark: #0D47A1;
            --accent: #00BCD4;
            --text-primary: #212121;
            --text-secondary: #757575;
            --background: #F5F5F5;
            --surface: #FFFFFF;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        body {
            background-color: var(--background);
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCI+PHBhdGggZmlsbD0iI2JiZGVmYiIgZmlsbC1vcGFjaXR5PSIwLjIiIGQ9Ik0xMS44NjMgMTEuODYzYTEgMSAwIDAxMS40MTQgMGw3NS44NiA3NS44NmExIDEgMCAwMS0xLjQxNCAxLjQxNGwtNzUuODYtNzUuODZhMSAxIDAgMDEwLTEuNDE0eiIvPjxwYXRoIGZpbGw9IiNiYmRlZmIiIGZpbGwtb3BhY2l0eT0iMC4yIiBkPSJNMTEuODYzIDExLjg2M2ExIDEgMCAwMTEuNDE0IDBsNzUuODYgNzUuODZhMSAxIDAgMDEtMS40MTQgMS40MTRsLTc1Ljg2LTc1Ljg2YTEgMSAwIDAxMC0xLjQxNHoiIHRyYW5zZm9ybT0icm90YXRlKDkwLCA1MCwgNTApIi8+PC9zdmc+');
        }overflow-x: hidden;
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: var(--surface);
            box-shadow: var(--shadow);
            padding: 15px 0;
            position: relative;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 60px;
            height: auto;
            margin-right: 15px;
            animation: pulse 2s infinite;
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
        }
        
        .user-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        
        .user-name {
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-danger {
            background-color: #ff4d4d;
            color: white;
            border: none;
        }
        
        .btn-danger:hover {
            background-color: #cc0000;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .main-content {
            padding: 40px 0;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary);
            position: relative;
            padding-bottom: 15px;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background-color: var(--accent);
            border-radius: 2px;
        }
        
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: var(--surface);
            padding: 30px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.8s forwards;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.2);
            outline: none;
        }
        
        .form-control-file {
            padding: 10px 0;
        }
        
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .btn-submit:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-submit i {
            margin-right: 10px;
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            z-index: 1000;
            transform: translateX(120%);
            opacity: 0;
            min-width: 300px;
        }
        
        .notification.success {
            background-color: #4CAF50;
        }
        
        .notification.error {
            background-color: #F44336;
        }
        
        .notification i {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .notification.show {
            animation: slideIn 0.5s forwards, slideOut 0.5s forwards 4s;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideIn {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            to {
                transform: translateX(120%);
                opacity: 0;
            }
        }
        
        .loader {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
            animation-delay: calc(var(--delay) * 0.1s);
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        
        .floating-icon {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: var(--primary);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .floating-icon:hover {
            transform: scale(1.1);
            background-color: var(--primary-dark);
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo-container">
                    <img src="assets/Images/logo.png" alt="Hospital Logo" class="logo">
                    <div class="logo-text">HealthCare Center</div>
                </div>
                <div class="user-actions">
                    
                    <a href="Staff Dashbord.html" class="btn btn-danger">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">
        <div class="container">
            <h2 class="page-title">Upload Lab Report</h2>
            
            <div class="form-container">
                <form method="POST" enctype="multipart/form-data" id="uploadForm">
                    <div class="form-group fade-in" style="--delay: 1;">
                        <label for="nic" class="form-label">
                            <i class="fas fa-id-card"></i> NIC:
                        </label>
                        <input type="text" id="nic" name="nic" class="form-control" required>
                    </div>
                    
                    <div class="form-group fade-in" style="--delay: 2;">
                        <label for="report_date" class="form-label">
                            <i class="fas fa-calendar-alt"></i> Report Date:
                        </label>
                        <input type="date" id="report_date" name="report_date" class="form-control" required>
                    </div>
                    
                    <div class="form-group fade-in" style="--delay: 3;">
                        <label for="report_file" class="form-label">
                            <i class="fas fa-file-medical"></i> Upload Report:
                        </label>
                        <input type="file" id="report_file" name="report_file" class="form-control form-control-file" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <button type="submit" class="btn-submit fade-in" style="--delay: 4;">
                        <i class="fas fa-upload"></i> Upload Report
                        <span class="loader" id="submitLoader"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    
    
    <div id="notification" class="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notificationText">Notification message</span>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function()) {
            const userName = localStorage.getItem('userName') || 'Staff';
            document.getElementById('userFirstName').textContent = `Welcome, ${userName}`;
            
            const form = document.getElementById('uploadForm');
            const loader = document.getElementById('submitLoader');
            
            form.addEventListener('submit', function(e)){
               
                loader.style.display = 'inline-block';
            
                const submitBtn = document.querySelector('.btn-submit');}}