<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, specialty, contact, email FROM doctors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details | Health Care Center</title>
    <style>
        body {
            background-color: var(--background);
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCI+PHBhdGggZmlsbD0iI2JiZGVmYiIgZmlsbC1vcGFjaXR5PSIwLjIiIGQ9Ik0xMS44NjMgMTEuODYzYTEgMSAwIDAxMS40MTQgMGw3NS44NiA3NS44NmExIDEgMCAwMS0xLjQxNCAxLjQxNGwtNzUuODYtNzUuODZhMSAxIDAgMDEwLTEuNDE0eiIvPjxwYXRoIGZpbGw9IiNiYmRlZmIiIGZpbGwtb3BhY2l0eT0iMC4yIiBkPSJNMTEuODYzIDExLjg2M2ExIDEgMCAwMTEuNDE0IDBsNzUuODYgNzUuODZhMSAxIDAgMDEtMS40MTQgMS40MTRsLTc1Ljg2LTc1Ljg2YTEgMSAwIDAxMC0xLjQxNHoiIHRyYW5zZm9ybT0icm90YXRlKDkwLCA1MCwgNTApIi8+PC9zdmc+');
        }

        .container {
            max-width: 1000px;
            margin: 80px auto 30px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 100, 200, 0.1);
            position: relative;
            z-index: 1;
            animation: fadeIn 0.8s ease-out;
        }

        .page-header {
            background: linear-gradient(135deg, #0066cc, #4da6ff);
            color: white;
            padding: 20px 0;
            position: relative;
            border-radius: 15px 15px 0 0;
            margin: -30px -30px 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin: 0;
            padding: 10px;
            font-size: 2.2rem;
            font-weight: 700;
            animation: slideInDown 0.5s ease-out;
        }

        .header-icon {
            display: inline-block;
            margin-right: 10px;
            animation: pulse 2s infinite;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            animation: slideInUp 0.7s ease-out;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: linear-gradient(to right, #007bff, #4da6ff);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        tr {
            background-color: white;
            transition: all 0.3s ease;
        }

        tr:nth-child(even) {
            background-color: #f8fbff;
        }

        tr:hover {
            background-color: #e6f2ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.15);
        }

        .top-nav {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideInDown 0.6s ease-out;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0066cc;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .dashboard-link {
            text-decoration: none;
            color: white;
            background-color: #ff4d4d;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .dashboard-link:hover {
            background-color: #ff2525;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .bg-shape {
            position: fixed;
            z-index: -1;
            opacity: 0.7;
        }

        .bg-shape-1 {
            top: -100px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(64, 144, 255, 0.2) 0%, rgba(64, 144, 255, 0) 70%);
            border-radius: 50%;
            animation: float 8s infinite ease-in-out;
        }

        .bg-shape-2 {
            bottom: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 210, 255, 0.2) 0%, rgba(0, 210, 255, 0) 70%);
            border-radius: 50%;
            animation: float 10s infinite ease-in-out reverse;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #777;
            background-color: #f8fbff;
            border-radius: 8px;
            animation: fadeIn 1s ease-out;
        }

        .empty-state svg {
            margin-bottom: 15px;
            color: #4da6ff;
            animation: pulse 2s infinite;
        }

        @media (max-width: 768px) {
            .container {
                margin: 70px 15px 20px;
                padding: 20px;
            }

            .page-header {
                margin: -20px -20px 20px;
            }

            h1 {
                font-size: 1.8rem;
            }

            th, td {
                padding: 10px;
                font-size: 0.9rem;
            }

            .responsive-table {
                overflow-x: auto;
                padding-bottom: 10px;
            }
        }

      
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>
  
    <div class="top-nav">
        <a href="index.php" class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
            Care Compass Hospital
        </a>
        <a href="Staff Dashbord.html" class="dashboard-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
    </div>

    <div class="container">
        <div class="page-header">
            <h1>
                <span class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </span>
                Our Medical Specialists
            </h1>
        </div>

        <div class="responsive-table">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Doctor Name</th>
                    <th>Specialty</th>
                    <th>Contact</th>
                    <th>Email</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['specialty']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['email']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>
                            <div class='empty-state'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                    <circle cx='12' cy='12' r='10'></circle>
                                    <line x1='12' y1='8' x2='12' y2='12'></line>
                                    <line x1='12' y1='16' x2='12.01' y2='16'></line>
                                </svg>
                                <h3>No Doctor Records Found</h3>
                                <p>We currently don't have any doctor records in our database.</p>
                            </div>
                          </td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.animation = `fadeIn 0.3s ease-out forwards ${0.1 + index * 0.1}s`;
            });
           
            const userName = localStorage.getItem('userName');
            if (userName) {
                document.getElementById('userFirstName').textContent = `Welcome, ${userName}`;
            }
         
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>