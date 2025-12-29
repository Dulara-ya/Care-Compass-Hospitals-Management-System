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
    
    $sql = "SELECT report_date, report_file FROM lab_reports WHERE nic = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    } else {
        echo "<script>alert('No reports found for the provided NIC number.');</script>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Lab Reports</title>
    <style>
        :root {
            --primary: #1a73e8;
            --secondary: #34a853;
            --accent: #5f6368;
            --light: #f8f9fa;
            --danger: #ea4335;
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
            animation: fadeInDown 0.5s ease-out;
        }
        
        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        h1, h2, h3 {
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .dashboard-link {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: white;
            background-color: var(--danger);
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .dashboard-link:hover {
            background-color: #d33426;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .search-form {
            max-width: 500px;
            margin: 0 auto 40px;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-out 0.2s both;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 100%;
        }
        
        .btn:hover {
            background-color: #0d62d0;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .results {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out 0.4s both;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .results-table th {
            background-color: var(--primary);
            color: white;
            padding: 15px;
            text-align: left;
        }
        
        .results-table td {
            border-bottom: 1px solid #e0e0e0;
            padding: 15px;
        }
        
        .results-table tr:last-child td {
            border-bottom: none;
        }
        
        .results-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .link:hover {
            color: #0d62d0;
            text-decoration: underline;
        }
        
        .link i {
            margin-right: 5px;
        }
        
        .empty-state {
            padding: 40px;
            text-align: center;
            color: var(--accent);
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        .health-icon {
            font-size: 24px;
            margin-right: 10px;
            color: var(--secondary);
        }
      
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
       
        @media (max-width: 768px) {
            .dashboard-link {
                position: relative;
                top: 0;
                right: 0;
                display: inline-block;
                margin-top: 20px;
            }
            
            header {
                text-align: center;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="assets/Images/logo.png" alt="Hospital Logo" class="logo pulse">
            <h1>Medical Laboratory Reports Portal</h1>
            <a href="Doctor Dashbord.html" class="dashboard-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </header>
        
        <form method="POST" class="search-form">
            <h2><i class="fas fa-search health-icon"></i>Search Lab Reports</h2>
            <div class="form-group">
                <label for="nic">Enter NIC Number</label>
                <input type="text" id="nic" name="nic" required class="form-control" placeholder="Enter your NIC number here">
            </div>
            <button type="submit" class="btn">
                <i class="fas fa-microscope"></i> Search Reports
            </button>
        </form>
        
        <?php if (!empty($search_results)): ?>
        <div class="results">
            <h3 style="padding: 15px;"><i class="fas fa-file-medical health-icon"></i>Your Reports</h3>
            <table class="results-table">
                <tr>
                    <th><i class="fas fa-calendar"></i> Report Date</th>
                    <th><i class="fas fa-file-alt"></i> Report File</th>
                    <th><i class="fas fa-download"></i> Download</th>
                </tr>
                <?php foreach ($search_results as $report): ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['report_date']); ?></td>
                    <td>
                        <a href="uploads/<?php echo htmlspecialchars($report['report_file']); ?>" target="_blank" class="link">
                            <i class="fas fa-eye"></i> View Report
                        </a>
                    </td>
                    <td>
                        <a href="uploads/<?php echo htmlspecialchars($report['report_file']); ?>" download class="link">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userFirstName = localStorage.getItem('userFirstName') || 'Guest';
            document.getElementById('userFirstName').textContent = `Welcome, ${userFirstName}`;
           
            const tableRows = document.querySelectorAll('.results-table tr');
            tableRows.forEach((row, index) => {
                if (index > 0) {
                    row.style.animation = `fadeIn 0.3s ease-out ${0.1 * index}s both`;
                }
            });
        });
        
        const formInput = document.querySelector('.form-control');
        if (formInput) {
            formInput.addEventListener('focus', function() {
                this.style.transform = 'translateX(5px)';
                setTimeout(() => {
                    this.style.transform = 'translateX(0)';
                }, 300);
            });
        }
    </script>
</body>
</html>