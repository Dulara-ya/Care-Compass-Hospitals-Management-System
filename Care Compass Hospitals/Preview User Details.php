<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "hospital_management"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_details = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['nic'];
    
    $nic = $conn->real_escape_string($nic);
    
    $sql = "SELECT first_name, last_name, gender, address, dob, phone_number, email FROM users WHERE nic = '$nic'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user_details = $result->fetch_assoc();
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'No User Found',
                    text: 'No user found for the provided NIC number.',
                    confirmButtonColor: '#007bff'
                });
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
    <title>Care Compass Hospital - User Search</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.4.8/sweetalert2.all.min.js"></script>
    <style>
        :root {
            --primary: #007bff;
            --primary-dark: #0056b3;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: var(--shadow);
            position: relative;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 15px;
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

        h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        .user-controls {
            display: flex;
            align-items: center;
        }

        .user-name {
            margin-right: 15px;
            color: var(--light);
            font-weight: 600;
        }

        .dashboard-link {
            text-decoration: none;
            color: white;
            background-color: var(--danger);
            padding: 8px 15px;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .dashboard-link:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .dashboard-link i {
            margin-right: 5px;
        }

        .main-content {
            padding: 2rem 0;
            text-align: center;
        }

        .search-title {
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-size: 2rem;
            animation: fadeInDown 1s ease;
        }

        .search-form {
            max-width: 450px;
            margin: 0 auto 2rem;
            padding: 1.5rem;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            animation: fadeIn 1s ease;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .user-details-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeInUp 1s ease;
        }

        .user-details-header {
            background-color: var(--primary);
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .user-details-content {
            padding: 1.5rem;
        }

        .user-details-row {
            display: flex;
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }

        .user-details-row:last-child {
            border-bottom: none;
        }

        .user-details-label {
            flex: 0 0 35%;
            font-weight: 600;
            color: var(--secondary);
        }

        .user-details-value {
            flex: 0 0 65%;
            color: var(--dark);
        }

        .hidden {
            display: none;
        }

        .animate__animated {
            animation-duration: 1s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            .logo-container {
                margin-bottom: 10px;
            }
            
            .user-controls {
                margin-top: 10px;
            }
            
            .user-details-row {
                flex-direction: column;
            }
            
            .user-details-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo-container">
                    <h1>Care Compass Hospital</h1>
                </div>
                    <a href="Doctor Dashbord.html" class="dashboard-link">
                        <i class="fas fa-home"></i>  Dashboard
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">
        <div class="container">
            <h2 class="search-title animate__animated animate__fadeInDown">
                <i class="fas fa-search"></i> Search User Details
            </h2>
            
            <form method="POST" class="search-form animate__animated animate__fadeIn">
                <div class="form-group">
                    <input type="text" name="nic" id="nicInput" class="form-control" placeholder="Enter NIC Number" required>
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>

            <?php if (!empty($user_details)): ?>
            <div class="user-details-container animate__animated animate__fadeInUp" id="userDetailsContainer">
                <div class="user-details-header">
                    <h3><i class="fas fa-user-circle"></i> User Details</h3>
                </div>
                <div class="user-details-content">
                    <div class="user-details-row">
                        <div class="user-details-label">First Name:</div>
                        <div class="user-details-value"><?php echo htmlspecialchars($user_details['first_name']); ?></div>
                    </div>
                    <div class="user-details-row">
                        <div class="user-details-label">Last Name:</div>
                        <div class="user-details-value"><?php echo htmlspecialchars($user_details['last_name']); ?></div>
                    </div>
                    <div class="user-details-row">
                        <div class="user-details-label">Gender:</div>
                        <div class="user-details-value"><?php echo htmlspecialchars($user_details['gender']); ?></div>
                    </div>
                    <div class="user-details-row">
                        <div class="user-details-label">Address:</div>
                        <div class="user-details-value"><?php echo htmlspecialchars($user_details['address']); ?></div>
                    </div>
                    <div class="user-details-row">
                        <div class="user-details-label">Date of Birth:</div>
                        <div class="user-details-value"><?php echo htmlspecialchars($user_details['dob']); ?></div>
                    </div>
                    <div class="user-details-row">
                        <div class="user-details-label">Phone Number:</div>
                        <div class="user-details-value"><?php echo htmlspecialchars($user_details['phone_number']); ?></div>
                    </div>
                    <div class="user-details-row">
                        <div class="user-details-label">Email:</div>
                        <div class="user-details-value"><?php echo htmlspecialchars($user_details['email']); ?></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() ){
            const userName = localStorage.getItem('userName') || 'Doctor';
            document.getElementById('userFirstName').textContent = userName;

            const searchBtn = document.querySelector('.btn');
            searchBtn.addEventListener('mouseover', function() {
                this.classList.add('animate__animated', 'animate__pulse');
            });
            searchBtn.addEventListener('animationend', function() {
                this.classList.remove('animate__animated', 'animate__pulse');
            });
            const nicInput = document.getElementById('nicInput');
            nicInput.addEventListener('focus', function() {
                this.style.borderColor = '#007bff';
                this.style.boxShadow = '0 0 0 3px rgba(0, 123, 255, 0.25)';
            });
            nicInput.addEventListener('blur', function() {
                this.style.borderColor = '#ddd';
                this.style.boxShadow = 'none';
            })};
    </script>
</body>
</html>

<?php