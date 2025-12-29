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
    $first_name = $_POST['Fname'];
    $last_name = $_POST['Lname'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $nic = $_POST['NIC'];
    $phone_number = $_POST['pnumber'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $password2 = $_POST['pass2'];

    if ($password !== $password2) {
        echo "<div class='alert alert-danger'>Passwords do not match!</div>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, gender, address, dob, nic, phone_number, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $first_name, $last_name, $gender, $address, $dob, $nic, $phone_number, $email, $password); // Fixed to use hashed_password

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Registration successful! You can now <a href='Login Page.php'>login</a>.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospitals</title>
    <style>
        :root {
            --primary: #1a73e8;
            --secondary: #34a853;
            --accent: #4285f4;
            --light: #f8f9fa;
            --dark: #202124;
            --danger: #ea4335;
            --success: #0f9d58;
        }
        
        * {
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e8f5fe 0%, #ffffff 100%);
            margin: 0;
            padding: 0;
            color: var(--dark);
            min-height: 100vh;
            animation: fadeIn 1s ease-out;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            animation: float 6s ease-in-out infinite;
        }
        .logout-btn {
            text-decoration: none;
            color: white;
            background-color: #ff4d4d;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .logout-btn:hover {
            background-color: #ff3333;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(255, 77, 77, 0.3);
        }
        
        .logo {
            height: 80px;
            margin: auto;
            display: block;
            animation: pulse 2s infinite;
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .logo-icon {
            color: var(--primary);
            font-size: 40px;
            margin-right: 10px;
        }
        
        .logo-text {
            font-size: 32px;
            font-weight: bold;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        h1 {
            color: var(--primary);
            margin: 0;
            font-size: 28px;
        }
        
        .subtitle {
            color: #666;
            font-size: 16px;
            margin-top: 5px;
        }
        
        fieldset {
            border: none;
            border-radius: 12px;
            padding: 30px;
            background-color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 0 auto 30px;
            position: relative;
            overflow: hidden;
            animation: fadeIn 1s ease-out;
        }
        
        fieldset::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }
        
        legend {
            font-size: 22px;
            font-weight: bold;
            color: var(--primary);
            padding: 0 10px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            color: var(--dark);
            background-color: #fff;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.1);
            outline: none;
        }
        
        .form-control:hover {
            border-color: #b8b8b8;
        }
        
        .radio-group {
            display: flex;
            gap: 20px;
            margin: 10px 0;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .radio-option input {
            margin-right: 8px;
            cursor: pointer;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn {
            display: inline-block;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            line-height: 1.5;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 0;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
            z-index: -1;
        }
        
        .btn:hover::after {
            width: 100%;
            left: 0;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
            width: 100%;
            margin-top: 10px;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1667cf, #3b78e7);
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        .btn-secondary {
            background: #f1f3f4;
            color: var(--dark);
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        
        .btn-secondary:hover {
            background: #e8eaed;
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .alert-danger {
            background-color: #ffebee;
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
        
        .alert-success {
            background-color: #e8f5e9;
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-login .btn {
            width: auto;
            display: inline-block;
        }
        
        .healthcare-icons {
            display: flex;
            justify-content: center;
            margin: 30px 0;
            gap: 40px;
        }
        
        .icon-box {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: float 5s ease-in-out infinite;
        }
        
        .icon-box:nth-child(2) {
            animation-delay: 1s;
        }
        
        .icon-box:nth-child(3) {
            animation-delay: 2s;
        }
        
        .icon {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .icon-text {
            font-size: 14px;
            color: #666;
        }
        
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(26, 115, 232, 0.1), rgba(66, 133, 244, 0.1));
            animation: float 8s infinite ease-in-out;
        }
        
        .bg-element:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
            animation-duration: 15s;
        }
        
        .bg-element:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 50%;
            right: -100px;
            animation-duration: 20s;
            animation-delay: 2s;
        }
        
        .bg-element:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: -75px;
            left: 30%;
            animation-duration: 18s;
            animation-delay: 5s;
        }
     
        @media (max-width: 768px) {
            fieldset {
                padding: 20px;
            }
            
            .healthcare-icons {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-elements">
        <div class="bg-element"></div>
        <div class="bg-element"></div>
        <div class="bg-element"></div>
    </div>

    <div class="container">
        <div class="header">
            <div class="logo">
                <div class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                    </svg>
                </div>
                <div class="logo-text">Care Compass Hospitals</div>
            </div>
            <h1>Patient Registration Portal</h1>
            <p class="subtitle">Join our healthcare family and experience the best medical care</p>
        </div>

        <div class="healthcare-icons">
            <div class="icon-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 0C1.46 6.7 1.33 10.28 4 13l8 8 8-8c2.67-2.72 2.54-6.3.42-8.42z"></path>
                    </svg>
                </div>
                <div class="icon-text">Patient-Centered Care</div>
            </div>
            <div class="icon-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                    </svg>
                </div>
                <div class="icon-text">24/7 Support</div>
            </div>
            <div class="icon-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 7h-3a2 2 0 0 1-2-2c0-1.1.9-2 2-2h3"></path>
                        <path d="M14 7H8a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-5"></path>
                        <path d="M3 15h3"></path>
                        <path d="M5 13v4"></path>
                    </svg>
                </div>
                <div class="icon-text">Expert Doctors</div>
            </div>
        </div>

        <form method="POST" id="registrationForm">
            <fieldset>
                <legend>Register Your Account</legend>

                <div class="form-group">
                    <label for="Fname">First Name</label>
                    <input type="text" id="Fname" name="Fname" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="Lname">Last Name</label>
                    <input type="text" id="Lname" name="Lname" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="gender" value="male"> Male
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="gender" value="female" checked> Female
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="NIC">National ID Card Number</label>
                    <input type="text" id="NIC" name="NIC" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="pnumber">Phone Number</label>
                    <input type="number" id="pnumber" name="pnumber" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="pass">Create Password</label>
                    <input type="password" id="pass" name="pass" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="pass2">Confirm Password</label>
                    <input type="password" id="pass2" name="pass2" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary" id="registerBtn">Register</button>
            </fieldset>
        </form>

        <div class="back-to-login">
            <a href="Login Page.php">
                <button class="btn btn-secondary">Back to Login</button>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formControls = document.querySelectorAll('.form-control');
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.02)';
                });
                
                control.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                });
            });
         
            const registerBtn = document.getElementById('registerBtn');
            registerBtn.addEventListener('mouseenter', function() {
                this.style.animation = 'pulse 0.5s ease infinite';
            });
            
            registerBtn.addEventListener('mouseleave', function() {
                this.style.animation = 'none';
            });
           
            const form = document.getElementById('registrationForm');
            form.addEventListener('submit', function(event) {
                const password = document.getElementById('pass').value;
                const password2 = document.getElementById('pass2').value;
                
                if(password !== password2) {
                    event.preventDefault();
                    if(!document.querySelector('.password-alert')) {
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-danger password-alert';
                        alert.textContent = 'Passwords do not match!';
                        document.getElementById('pass2').parentNode.appendChild(alert);
                   
                        document.getElementById('pass').style.animation = 'shake 0.5s ease';
                        document.getElementById('pass2').style.animation = 'shake 0.5s ease';
                        
                        setTimeout(() => {
                            document.getElementById('pass').style.animation = '';
                            document.getElementById('pass2').style.animation = '';
                        }, 500);
                    }
                }
            });
        });
        
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
            </style>
        `);
        
    </script>
</body>

</html>

<?php
$conn->close();
?>