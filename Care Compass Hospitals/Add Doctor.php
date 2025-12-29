<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "hospital_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $specialty = trim($_POST['specialty']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; 
    
    if (empty($id) || empty($name) || empty($specialty) || empty($contact) || empty($email) || empty($password)) {
        $error_message = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO doctors (id, name, specialty, contact, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $id, $name, $specialty, $contact, $email, $password); 

        if ($stmt->execute()) {
            $success_message = "New doctor added successfully";
        } else {
            $error_message = "Error adding doctor: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor | Hospital Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #1a73e8;
            --secondary: #34a853;
            --accent: #ea4335;
            --light: #f8f9fa;
            --dark: #202124;
            --success: #28a745;
            --danger: #dc3545;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
            padding: 50px 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: var(--shadow);
            position: relative;
            z-index: 1;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            z-index: 2;
        }
        
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            margin-right: 20px;
            animation: pulse 2s infinite;
        }
        
        h2 {
            color: var(--primary);
            font-size: 28px;
            font-weight: 600;
            flex-grow: 1;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 500;
            font-size: 16px;
        }
        
        .input-container {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s;
        }
        
        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
        }
        
        input:hover {
            border-color: #aaa;
        }
        
        .btn {
            background: linear-gradient(45deg, var(--primary), #4285f4);
            color: white;
            padding: 14px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 8px rgba(26, 115, 232, 0.3);
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: linear-gradient(45deg, #0d62d9, #2d76e5);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(26, 115, 232, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(26, 115, 232, 0.3);
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        .btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        
        
        .dashboard-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: white;
            background-color: var(--accent);
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: var(--shadow);
            transition: all 0.3s;
            text-decoration: white;
            background-color: red;
            color: white;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .dashboard-link:hover {
            background-color: #d62516;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(234, 67, 53, 0.3);
        }
        
        .dashboard-icon {
            margin-right: 38px;
        }
        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
            animation: slideDown 0.5s ease-out;
        }
        
        .success {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        
        .error {
            background-color: rgba(220, 53, 69, 0.15);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
       
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            20% {
                transform: scale(25, 25);
                opacity: 0.5;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }

        .float {
            position: absolute;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            opacity: 0.1;
            z-index: -1;
        }
        
        .float-1 {
            top: 10%;
            left: 10%;
            animation: float 8s infinite ease-in-out;
        }
        
        .float-2 {
            top: 60%;
            left: 80%;
            width: 100px;
            height: 100px;
            animation: float 12s infinite ease-in-out;
        }
        
        .float-3 {
            top: 80%;
            left: 20%;
            width: 70px;
            height: 70px;
            animation: float 10s infinite ease-in-out;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
            100% {
                transform: translateY(0) rotate(360deg);
            }
        }
      
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
            }
            
            .logo {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .dashboard-link {
                position: static;
                margin-top: 20px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="float float-1"></div>
    <div class="float float-2"></div>
    <div class="float float-3"></div>

    <a href="Staff Dashbord.html" class="dashboard-link">
        <i class="fas fa-home"></i>    Dashboard
    </a>
    
    <div class="container">
        <div class="header">
            <svg class="logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill="#1a73e8" d="M19,3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3z M18,19H6 c-0.55,0-1-0.45-1-1V6c0-0.55,0.45-1,1-1h12c0.55,0,1,0.45,1,1v12C19,18.55,18.55,19,18,19z"/>
                <path fill="#ea4335" d="M10.5,17h3v-3.5H17v-3h-3.5V7h-3v3.5H7v3h3.5z"/>
            </svg>
            <h2>Add New Doctor</h2>
        </div>
        
        <?php if (!empty($success_message)): ?>
        <div class="message success">
            <i class="fas fa-check-circle"></i> <?php echo $success_message; ?> 
            <a href="Doctor Detils staff.php">View All Doctors</a>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
        <div class="message error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
        </div>
        <?php endif; ?>
        
        <form action="" method="POST" id="doctorForm">
            <div class="form-group">
                <label for="id">Doctor ID</label>
                <div class="input-container">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" name="id" id="id" placeholder="Enter doctor ID" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <div class="input-container">
                    <i class="fas fa-user-md input-icon"></i>
                    <input type="text" name="name" id="name" placeholder="Enter doctor's full name" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="specialty">Specialty</label>
                <div class="input-container">
                    <i class="fas fa-stethoscope input-icon"></i>
                    <input type="text" name="specialty" id="specialty" placeholder="Enter medical specialty" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="contact">Contact Number</label>
                <div class="input-container">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="tel" name="contact" id="contact" placeholder="Enter contact number" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-container">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" id="email" placeholder="Enter email address" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-container">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password" placeholder="Enter password" required>
                </div>
            </div>
            
            <button type="submit" class="btn" id="submitBtn">Add Doctor</button>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('doctorForm');
            const inputs = form.querySelectorAll('input');
            const submitBtn = document.getElementById('submitBtn');
          
            inputs.forEach((input, index) => {
                input.style.opacity = '0';
                input.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    input.style.opacity = '1';
                    input.style.transform = 'translateY(0)';
                }, 200 + (index * 100));
             
                input.addEventListener('focus', function() {
                    this.parentNode.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentNode.style.transform = 'scale(1)';
                  
                    if (this.value.trim() === '') {
                        this.style.borderColor = '#dc3545';
                        this.style.backgroundColor = 'rgba(220, 53, 69, 0.05)';
                    } else {
                        if (this.type === 'email' && !validateEmail(this.value)) {
                            this.style.borderColor = '#dc3545';
                            this.style.backgroundColor = 'rgba(220, 53, 69, 0.05)';
                        } else if (this.type === 'password' && this.value.length < 6) {
                            this.style.borderColor = '#dc3545';
                            this.style.backgroundColor = 'rgba(220, 53, 69, 0.05)';
                        } else {
                            this.style.borderColor = '#28a745';
                            this.style.backgroundColor = 'rgba(40, 167, 69, 0.05)';
                        }
                    }
                });
            });
            
            submitBtn.style.opacity = '0';
            setTimeout(() => {
                submitBtn.style.opacity = '1';
            }, 200 + (inputs.length * 100));
            
            form.addEventListener('submit', function(e) {
                const allValid = validateForm();
                if (!allValid) {
                    e.preventDefault();
                    showMessage('Please fill all fields correctly', 'error');
                } else {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding Doctor...';
                    submitBtn.disabled = true;
                }
            });
            
            function validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
            
            function validateForm() {
                let valid = true;
                inputs.forEach(input => {
                    if (input.value.trim() === '') {
                        valid = false;
                    } else if (input.type === 'email' && !validateEmail(input.value)) {
                        valid = false;
                    } else if (input.type === 'password' && input.value.length < 6) {
                        valid = false;
                    }
                });
                return valid;
            }
            
            function showMessage(message, type) {
                let existingMessage = document.querySelector('.message');
                if (existingMessage) {
                    existingMessage.remove();
                }
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${type}`;
                messageDiv.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation' : 'check'}-circle"></i> ${message}`;
                
                const header = document.querySelector('.header');
                header.insertAdjacentElement('afterend', messageDiv);
                
                setTimeout(() => {
                    messageDiv.remove();
                }, 5000);
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>