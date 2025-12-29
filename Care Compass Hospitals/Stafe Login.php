<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "hospital_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $epf = $_POST["EPF"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM staff WHERE `epf` = ? AND `password` = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $epf, $password);

    $stmt->execute ();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        header("Location:Staff Dashbord.html");
    } else {
        
        echo "<script>alert('Invalid EPF or password.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospital - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            max-width: 1200px;
            padding: 20px;
            gap: 30px;
        }
        .hero {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.15);
            width: 350px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .hero:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 123, 255, 0.25);
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #007bff, #00e0ff);
            z-index: 2;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
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
        
        .logo img {
            width: 120px;
            transition: transform 0.3s ease;
        }
        
        .logo img:hover {
            transform: rotate(5deg);
        }
        
        legend {
            color: #0056b3;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 10px;
        }
        
        h1 {
            color: #007bff;
            font-size: 28px;
            text-align: center;
            margin-bottom: 25px;
            position: relative;
            font-weight: 700;
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #007bff, #00e0ff);
            border-radius: 3px;
        }
        
        /* Form Styles */
        label {
            color: #333;
            font-weight: 600;
            display: block;
            margin: 15px 0 5px;
            font-size: 15px;
            transition: color 0.3s ease;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 5px 0 20px 0;
            border: 2px solid #e1e5ee;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #f8f9fb;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            outline: none;
            background-color: #fff;
        }
        button {
            background: linear-gradient(90deg, #007bff, #0069d9);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin: 10px 0;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        button:hover {
            background: linear-gradient(90deg, #0069d9, #005cbf);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 123, 255, 0.25);
        }
        
        button:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
        }
        
        button::after {
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
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        button:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        
        .emergency-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .emergency-info {
            width: 380px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(255, 81, 81, 0.1);
            transition: transform 0.3s ease;
        }
        
        .emergency-info:hover {
            transform: scale(1.02);
        }
        
        .emergency-text {
            margin-top: 20px;
            color: white;
            font-size: 15px;
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #ff5757, #ff3131);
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(255, 81, 81, 0.2);
            transition: all 0.3s ease;
        }
        
        .emergency-text:hover {
            box-shadow: 0 12px 20px rgba(255, 81, 81, 0.3);
            transform: translateY(-3px);
        }
        
        .emergency-text h3 {
            font-size: 22px;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
            padding-bottom: 8px;
        }
        
        .emergency-text h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 3px;
        }
        
        .emergency-text p {
            margin: 10px 0;
            line-height: 1.5;
        }
        
        .emergency-text b {
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.5px;
        }
        
        
        .hotline {
            display: inline-block;
            animation: pulse-text 1.5s infinite;
            font-weight: 700;
        }
        
        @keyframes pulse-text {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
            }
        }
        
        .floating {
            position: absolute;
            width: 50px;
            height: 50px;
            background-color: rgba(0, 123, 255, 0.1);
            border-radius: 50%;
            z-index: -1;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
        @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .hero, .emergency-info, .emergency-text {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div id="floating-elements"></div>

    <div class="container">
        <div class="hero">
            <div class="logo">
                <img src="assets/Images/logonew.png" alt="Care Compass Hospital Logo">
            </div>

            <section id="hero">
                <legend>Welcome to Care Compass Hospital</legend>
                <h1>Staff Login</h1>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label>Enter EPF</label>
                <input type="text" name="EPF" size="12">

                <label>Password</label>
                <input type="password" name="password" size="12">

                <button type="submit">Login</button>
    </Form>
                <a href="Admin Login.php" style="text-decoration: none;">
                    <button>Admin Login</button>
                </a>
                <a href="Doctors Login.php" style="text-decoration: none;">
                        <button>Doctor Login</button>
                    </a>
                    <a href="Login Page.php" style="text-decoration: none;">
                        <button>User Login</button>

                    </a>
            </section>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const floatingContainer = document.getElementById('floating-elements');
            
            for (let i = 0; i < 15; i++) {
                createFloatingElement(floatingContainer);
            }
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const rect = button.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.width = '1px';
                    ripple.style.height = '1px';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear forwards';
                    
                    button.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    const label = this.previousElementSibling;
                    if (label && label.tagName === 'LABEL') {
                        label.style.color = '#007bff';
                    }
                });
                
                input.addEventListener('blur', function() {
                    const label = this.previousElementSibling;
                    if (label && label.tagName === 'LABEL') {
                        label.style.color = '#333';
                    }
                });
            });
        });
        
        function createFloatingElement(container) {
            const element = document.createElement('div');
            element.classList.add('floating');
            
            const posX = Math.random() * window.innerWidth;
            const posY = Math.random() * window.innerHeight;
           
            const size = Math.random() * 50 + 20;
            
          
            const duration = Math.random() * 10 + 10;
            
            const borderRadius = Math.random() > 0.5 ? '50%' : '10%';
            
            const hue = Math.random() > 0.7 ? '190' : '210';
            const color = `hsla(${hue}, 100%, 50%, 0.1)`;
            
            element.style.left = posX + 'px';
            element.style.top = posY + 'px';
            element.style.width = size + 'px';
            element.style.height = size + 'px';
            element.style.borderRadius = borderRadius;
            element.style.backgroundColor = color;
            element.style.animation = `float ${duration}s linear infinite`;
         
            container.appendChild(element);
        }
        
        document.querySelector('form').addEventListener('submit', function(event) {
            let valid = true;
            const inputs = this.querySelectorAll('input[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.style.borderColor = '#ff3131';
                    input.style.animation = 'shake 0.5s ease-in-out';
                    
                    setTimeout(() => {
                        input.style.animation = '';
                    }, 500);
                } else {
                    input.style.borderColor = '#e1e5ee';
                }
            });
            
            if (!valid) {
                event.preventDefault();
            }
        });
        
        if (!document.querySelector('#shake-keyframes')) {
            const style = document.createElement('style');
            style.id = 'shake-keyframes';
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
                
                @keyframes ripple {
                    0% { transform: scale(0); opacity: 1; }
                    100% { transform: scale(15); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }
    </script>
   </body>

</html>