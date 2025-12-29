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
    $patient_id = $_POST['patient_id'];
    $medication_name = $_POST['medication_name'];
    $dosage = $_POST['dosage'];
    $prescription_file = $_FILES['prescription_file']['name'];
    $prescription_file_tmp = $_FILES['prescription_file']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($prescription_file);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    $allowed_types = array('pdf', 'jpg', 'jpeg', 'png');
    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($prescription_file_tmp, $target_file)) {
            $sql = "INSERT INTO prescriptions (nic, patient_id, medication_name, dosage, prescription_file) VALUES ('$nic', '$patient_id', '$medication_name', '$dosage', '$prescription_file')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('success', 'Prescription uploaded successfully!');
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
    <title>Upload Prescription</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c7be5;
            --secondary-color: #1a5dab;
            --accent-color: #e63946;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: all 0.3s ease;
        }

        body {
            background-color: var(--background);
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCI+PHBhdGggZmlsbD0iI2JiZGVmYiIgZmlsbC1vcGFjaXR5PSIwLjIiIGQ9Ik0xMS44NjMgMTEuODYzYTEgMSAwIDAxMS40MTQgMGw3NS44NiA3NS44NmExIDEgMCAwMS0xLjQxNCAxLjQxNGwtNzUuODYtNzUuODZhMSAxIDAgMDEwLTEuNDE0eiIvPjxwYXRoIGZpbGw9IiNiYmRlZmIiIGZpbGwtb3BhY2l0eT0iMC4yIiBkPSJNMTEuODYzIDExLjg2M2ExIDEgMCAwMTEuNDE0IDBsNzUuODYgNzUuODZhMSAxIDAgMDEtMS40MTQgMS40MTRsLTc1Ljg2LTc1Ljg2YTEgMSAwIDAxMC0xLjQxNHoiIHRyYW5zZm9ybT0icm90YXRlKDkwLCA1MCwgNTApIi8+PC9zdmc+');
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        header {
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .logo i {
            font-size: 28px;
        }

        .user-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: bold;
            color: var(--primary-color);
        }

        .dashboard-btn {
            text-decoration: none;
            color: white;
            background-color: var(--accent-color);
            padding: 10px 18px;
            border-radius: 50px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 8px rgba(230, 57, 70, 0.3);
        }

        .dashboard-btn:hover {
            background-color: #d32f3d;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(230, 57, 70, 0.4);
        }

        .page-title {
            text-align: center;
            margin: 40px 0;
            color: var(--primary-color);
            font-size: 32px;
            font-weight: 700;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }

        .page-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto 40px;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeUp 0.8s forwards;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 12px 20px;
            font-size: 16px;
            border: 2px solid #e1e5eb;
            border-radius: 8px;
            background-color: #f8f9fa;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.2);
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .file-upload {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            border: 2px dashed #e1e5eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload:hover {
            border-color: var(--primary-color);
        }

        .file-upload i {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .file-upload-text {
            text-align: center;
            margin-bottom: 10px;
        }

        .file-upload input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .file-name {
            font-size: 14px;
            color: #6c757d;
            margin-top: 10px;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 4px 12px rgba(44, 123, 229, 0.3);
            transition: all 0.3s;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(44, 123, 229, 0.4);
        }

        .notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transform: translateY(100px);
            opacity: 0;
        }

        .notification.success {
            background-color: var(--success-color);
        }

        .notification.error {
            background-color: var(--error-color);
        }

        .notification.show {
            animation: slideUp 0.4s forwards, fadeOut 0.4s 3s forwards;
        }

        .form-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #adb5bd;
        }

        .form-with-icon .form-control {
            padding-left: 45px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
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
    </style>
</head>
<body>

<header>
    <div class="logo">
        <i class="fas fa-hospital-alt"></i>
        <span>Care Compass Hospitals</span>
    </div>
    <div class="user-controls">
        
        <a href="Doctor Dashbord.html" class="dashboard-btn">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
    </div>
</header>

<div class="container">
    <h2 class="page-title">Upload Prescription</h2>
    
    <div class="card">
        <div class="card-header">
            <h3>Patient Prescription Form</h3>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data" id="prescriptionForm">
                <div class="form-group form-with-icon">
                    <i class="fas fa-id-card form-icon"></i>
                    <input type="text" class="form-control" name="nic" id="nic" placeholder="National ID Card Number" required>
                </div>
                
                <div class="form-group form-with-icon">
                    <i class="fas fa-user form-icon"></i>
                    <input type="text" class="form-control" name="patient_id" id="patient_id" placeholder="Patient ID" required>
                </div>
                
                <div class="form-group form-with-icon">
                    <i class="fas fa-pills form-icon"></i>
                    <input type="text" class="form-control" name="medication_name" id="medication_name" placeholder="Medication Name" required>
                </div>
                
                <div class="form-group form-with-icon">
                    <i class="fas fa-prescription form-icon"></i>
                    <input type="text" class="form-control" name="dosage" id="dosage" placeholder="Dosage" required>
                </div>
                
                <div class="form-group">
                    <div class="file-upload" id="fileUploadContainer">
                        <i class="fas fa-cloud-upload-alt floating"></i>
                        <div class="file-upload-text">
                            <p>Drag & drop your prescription file here</p>
                            <p>or</p>
                            <p><strong>Click to browse</strong></p>
                        </div>
                        <input type="file" name="prescription_file" id="prescription_file" required>
                        <div class="file-name" id="fileName"></div>
                    </div>
                </div>
                
                <button type="submit" class="btn pulse">
                    <i class="fas fa-upload"></i> Upload Prescription
                </button>
            </form>
        </div>
    </div>
</div>

<div id="notification" class="notification"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File upload
        const fileInput = document.getElementById('prescription_file');
        const fileUploadContainer = document.getElementById('fileUploadContainer');
        const fileName = document.getElementById('fileName'))
        fileInput.addEventListener('change', function() {
            const selectedFile = fileInput.files[0];
            if (selectedFile) {
                fileName.textContent = selectedFile.name;
            } else {
                fileName.textContent = '';
            }});
        fileUploadContainer.addEventListener('click', function() {
            fileInput.click();
        });
    });
</script>

</body>
</html>