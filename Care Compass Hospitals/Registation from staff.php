<!DOCTYPE html>
<html>
<head>
<title>Registration Form</title>
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e8f5fe 0%, #ffffff 100%);
            margin: 0;
            padding: 0;
            color: var(--dark);
            min-height: 100vh;
            animation: fadeIn 1s ease-out;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCI+PHBhdGggZmlsbD0iI2JiZGVmYiIgZmlsbC1vcGFjaXR5PSIwLjIiIGQ9Ik0xMS44NjMgMTEuODYzYTEgMSAwIDAxMS40MTQgMGw3NS44NiA3NS44NmExIDEgMCAwMS0xLjQxNCAxLjQxNGwtNzUuODYtNzUuODZhMSAxIDAgMDEwLTEuNDE0eiIvPjxwYXRoIGZpbGw9IiNiYmRlZmIiIGZpbGwtb3BhY2l0eT0iMC4yIiBkPSJNMTEuODYzIDExLjg2M2ExIDEgMCAwMTEuNDE0IDBsNzUuODYgNzUuODZhMSAxIDAgMDEtMS40MTQgMS40MTRsLTc1Ljg2LTc1Ljg2YTEgMSAwIDAxMC0xLjQxNHoiIHRyYW5zZm9ybT0icm90YXRlKDkwLCA1MCwgNTApIi8+PC9zdmc+');
        }

.container {
    width: 400px;
    background-color: #fff;
    padding: 20px;
    margin: 50px auto;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.8s ease-out;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    position: relative;
}

h2:after {
    content: '';
    display: block;
    width: 50px;
    height: 3px;
    background-color: #007bff;
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    transition: width 0.3s;
}

.container:hover h2:after {
    width: 100px;
}

.form-group {
    margin-bottom: 15px;
    animation: fadeIn 0.5s ease-out;
    animation-fill-mode: both;
}

.form-group:nth-child(1) { animation-delay: 0.1s; }
.form-group:nth-child(2) { animation-delay: 0.2s; }
.form-group:nth-child(3) { animation-delay: 0.3s; }
.form-group:nth-child(4) { animation-delay: 0.4s; }
.form-group:nth-child(5) { animation-delay: 0.5s; }
.form-group:nth-child(6) { animation-delay: 0.6s; }
.form-group:nth-child(7) { animation-delay: 0.7s; }

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
    transition: color 0.3s;
}

input[type="text"], 
input[type="password"], 
input[type="email"], 
select {
    width: 100%;
    padding: 12px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    transition: all 0.3s;
}

input[type="text"]:focus, 
input[type="password"]:focus, 
input[type="email"]:focus, 
select:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    outline: none;
}

input[type="submit"] {
    background-color: #007bff; 
    color: #fff;
    border: none;
    padding: 12px 20px;
    margin: 15px 0;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    transition: all 0.3s;
    animation: pulse 1.5s infinite;
}

input[type="submit"]:hover {
    background-color: #0062cc;
    transform: scale(1.02);
    animation: none;
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
            color: red;
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

.back-to-login {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-login .btn {
            width: auto;
            display: inline-block;
 }
        

.error {
    color: red;
    margin-bottom: 10px;
    animation: shake 0.5s;
}

.success-message {
    color: green;
    text-align: center;
    padding: 10px;
    margin-top: 15px;
    border-radius: 4px;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    animation: fadeIn 0.5s;
}

.error-message {
    color: #721c24;
    text-align: center;
    padding: 10px;
    margin-top: 15px;
    border-radius: 4px;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    animation: shake 0.5s;
}
</style>
</head>
<body>

<div class="container"> 
<h2>Registration Form</h2>
<form method="post" action="" id="registrationForm">
    <div class="form-group">
        <label for="epf">EPF Number:</label>
        <input type="text" name="epf" id="epf" required>
    </div>
    
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
    </div>
    
    <div class="form-group">
        <label for="position">Position:</label>
        <select name="position" id="position" required>
            <option value="">Select position</option>
            <option value="nurse">Nurse</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required>
    </div>
    
    <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" id="phone" required>
        <div id="phoneError" class="error" style="display: none;">Please enter a valid 10-digit phone number.</div>
    </div>
    
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <div id="passwordError" class="error" style="display: none;">Password must be at least 8 characters long.</div>
    </div>
    
    <div class="form-group">
        <input type="submit" value="Register" id="submitBtn">
    </div>
</form>
<div class="back-to-login">
            <a href="Login Page.php">
                <button class="btn btn-secondary">Back to Login</button>
            </a>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const phoneInput = document.getElementById('phone');
    const phoneError = document.getElementById('phoneError');
    const passwordInput = document.getElementById('password');
    const passwordError = document.getElementById('passwordError');
    const submitBtn = document.getElementById('submitBtn');
 
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.querySelector('label').style.color = '#007bff';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.querySelector('label').style.color = '#555';
        });
    });
  
    phoneInput.addEventListener('input', function() {
        const phonePattern = /^[0-9]{10}$/;
        if (!phonePattern.test(this.value) && this.value.length > 0) {
            phoneError.style.display = 'block';
            this.style.borderColor = '#dc3545';
        } else {
            phoneError.style.display = 'none';
            this.style.borderColor = this.value.length === 10 ? '#28a745' : '#ccc';
        }
    });
    
    passwordInput.addEventListener('input', function() {
        if (this.value.length < 8 && this.value.length > 0) {
            passwordError.style.display = 'block';
            this.style.borderColor = '#dc3545';
        } else {
            passwordError.style.display = 'none';
            this.style.borderColor = this.value.length >= 8 ? '#28a745' : '#ccc';
        }
    });
   
    form.addEventListener('submit', function(event) {
        let isValid = true;
      
        const phonePattern = /^[0-9]{10}$/;
        if (!phonePattern.test(phoneInput.value)) {
            phoneError.style.display = 'block';
            phoneInput.style.borderColor = '#dc3545';
            isValid = false;
          
            phoneInput.parentElement.style.animation = 'shake 0.5s';
            setTimeout(() => {
                phoneInput.parentElement.style.animation = '';
            }, 500);
        }
      
        if (passwordInput.value.length < 8) {
            passwordError.style.display = 'block';
            passwordInput.style.borderColor = '#dc3545';
            isValid = false;
       
            passwordInput.parentElement.style.animation = 'shake 0.5s';
            setTimeout(() => {
                passwordInput.parentElement.style.animation = '';
            }, 500);
        }
        
        if (!isValid) {
            event.preventDefault();
          
            const firstError = document.querySelector('.error[style="display: block;"]');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } else {
            submitBtn.value = 'Registering...';
            submitBtn.style.opacity = '0.7';
        }
    });
});
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hospital_management";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("<div class='error-message'>Connection failed: " . $conn->connect_error . "</div>");
    }

    $epf = $_POST["epf"];
    $name = $_POST["name"];
    $position = $_POST["position"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO Staff (epf, name, position, address, phone, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $epf, $name, $position, $address, $phone, $password);
    
    if ($stmt->execute()) {
        echo "<div class='success-message'>Registration successful! You can now <a href='staff login.php'>login</a>.</div>";
        echo "<script>
            document.getElementById('registrationForm').reset();
            setTimeout(function() {
                window.location.href = 'staff login.php';
            }, 3000);
        </script>";
    } else {
        echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
</div>

</body>
</html>