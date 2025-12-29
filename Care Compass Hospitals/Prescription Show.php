<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "hospital_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['nic'];
    
    $nic = $conn->real_escape_string($nic);
   
    $sql = "SELECT medication_name, dosage, prescription_file FROM prescriptions WHERE nic = '$nic'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('No prescriptions found for the provided NIC number.', 'error');
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
    <title>Search Prescriptions</title>
    <style>
        :root {
            --primary: #1a73e8;
            --secondary: #34a853;
            --accent: #5f6368;
            --light: #f8f9fa;
            --danger: #ea4335;
            --transition-speed: 0.4s;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            position: relative;
            animation: fadeInDown 0.8s ease-out;
        }
        
        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 10px;
            transition: transform 0.5s ease;
            animation: pulse 3s infinite;
        }
        
        .logo:hover {
            transform: scale(1.1) rotate(5deg);
        }
        
        h1, h2, h3 {
            color: var(--primary);
            margin-bottom: 15px;
            position: relative;
        }
        
        h1::after, h2::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .dashboard-link {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: white;
            background-color: var(--danger);
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 10px rgba(234, 67, 53, 0.3);
            display: flex;
            align-items: center;
        }
        
        .dashboard-link:hover {
            background-color: #d33426;
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 6px 12px rgba(234, 67, 53, 0.4);
        }
        
        .dashboard-link i {
            margin-right: 8px;
            font-size: 18px;
        }
        
        .search-form {
            max-width: 550px;
            margin: 0 auto 50px;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: fadeIn 0.6s ease-out 0.3s forwards;
            position: relative;
            overflow: hidden;
        }
        
        .search-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 8px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            border-radius: 15px 0 0 15px;
        }
        
        .form-title {
            margin-bottom: 25px;
            font-size: 24px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent);
            transition: all var(--transition-speed) ease;
        }
        
        .form-control {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all var(--transition-speed) ease;
            background-color: #f9f9f9;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
            background-color: white;
        }
        
        .form-control:focus + i {
            color: var(--primary);
        }
        
        .btn {
            display: block;
            width: 100%;
            background: linear-gradient(to right, var(--primary), #0d62d0);
            color: white;
            border: none;
            padding: 15px 25px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 15px rgba(26, 115, 232, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(26, 115, 232, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: -100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .btn:hover::after {
            left: 100%;
        }
        
        .results {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeIn 0.6s ease-out 0.5s forwards;
            margin-bottom: 40px;
        }
        
        .results-header {
            background: linear-gradient(to right, var(--primary), #0d62d0);
            color: white;
            padding: 20px;
            font-size: 20px;
            border-radius: 15px 15px 0 0;
            display: flex;
            align-items: center;
        }
        
        .results-header i {
            margin-right: 10px;
            font-size: 24px;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .results-table th {
            background-color: #f1f8ff;
            color: var(--primary);
            padding: 15px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #e1efff;
        }
        
        .results-table td {
            border-bottom: 1px solid #e0e0e0;
            padding: 15px;
            transition: all 0.3s ease;
        }
        
        .results-table tr:last-child td {
            border-bottom: none;
        }
        
        .results-table tr {
            transition: all 0.3s ease;
        }
        
        .results-table tr:hover {
            background-color: #f5f9ff;
            transform: translateX(5px);
        }
        
        .download-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            background-color: var(--secondary);
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(52, 168, 83, 0.3);
        }
        
        .download-link:hover {
            background-color: #2d9448;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(52, 168, 83, 0.4);
        }
        
        .download-link i {
            margin-right: 5px;
        }
        
        .empty-state {
            padding: 40px;
            text-align: center;
            color: var(--accent);
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            transform: translateX(150%);
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification i {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .notification.success {
            background-color: var(--secondary);
        }
        
        .notification.error {
            background-color: var(--danger);
        }
        
        .icon-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 50%;
            margin-right: 10px;
        }
       
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
       
        @media (max-width: 768px) {
            .dashboard-link {
                position: static;
                margin: 20px auto 0;
                display: inline-flex;
            }
            
            header {
                padding-bottom: 30px;
            }
            
            .results-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="assets/Images/logo.png" alt="Hospital Logo" class="logo">
            <h1>Medical Prescriptions Portal</h1>
            <a href="User Dashbord.html" class="dashboard-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </header>

        <div class="search-form">
            <h2 class="form-title">Search Prescriptions by NIC</h2>
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="nic" id="nic" class="form-control" placeholder="Enter NIC Number" required>
                    <i class="fas fa-id-card"></i>
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-search"></i> Search Prescriptions
                </button>
            </form>
        </div>

        <?php if (!empty($search_results)): ?>
        <div class="results">
            <div class="results-header">
                <div class="icon-badge">
                    <i class="fas fa-pills"></i>
                </div>
                Prescription Results
            </div>
            <table class="results-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-prescription-bottle-alt"></i> Medication Name</th>
                        <th><i class="fas fa-capsules"></i> Dosage</th>
                        <th><i class="fas fa-file-download"></i> Prescription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($search_results as $prescription): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prescription['medication_name']); ?></td>
                        <td><?php echo htmlspecialchars($prescription['dosage']); ?></td>
                        <td>
                            <a href="uploads/<?php echo htmlspecialchars($prescription['prescription_file']); ?>" 
                               class="download-link" download>
                                <i class="fas fa-download"></i> Download
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
                    </head>
    </body>
    </html>