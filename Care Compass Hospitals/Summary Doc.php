<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "hospital_management"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch appointment counts by branch
$branch_query = "SELECT branch, COUNT(*) as count FROM appointments GROUP BY branch";
$branch_result = $conn->query($branch_query);

$branch_data = [];
$branch_labels = [];
$total_appointments = 0;

if ($branch_result->num_rows > 0) {
    while ($row = $branch_result->fetch_assoc()) {
        $branch_data[] = $row['count'];
        $branch_labels[] = $row['branch'];
        $total_appointments += $row['count'];
    }
}

// Fetch appointment counts by doctor
$doctor_query = "SELECT doctor_id, COUNT(*) as count FROM appointments GROUP BY doctor_id";
$doctor_result = $conn->query($doctor_query);

$doctor_data = [];
$doctor_labels = [];

if ($doctor_result->num_rows > 0) {
    while ($row = $doctor_result->fetch_assoc()) {
        $doctor_data[] = $row['count'];
        $doctor_labels[] = $row['doctor_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Visualization</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
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
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #007BFF;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
            transition: all 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 123, 255, 0.25);
        }
        h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 30px;
            position: relative;
        }
        h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #007BFF, transparent);
        }
        #chartContainer {
            margin-top: 40px;
        }
        .chart-wrapper {
            margin-bottom: 60px;
            padding: 20px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .chart-title {
            margin-bottom: 20px;
            color: #555;
            font-size: 18px;
            text-align: center;
        }
        .stats-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 30px 0;
        }
        .stat-card {
            width: 150px;
            padding: 15px;
            margin: 10px;
            text-align: center;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transform: translateY(30px);
            opacity: 0;
        }
        .stat-card .value {
            font-size: 26px;
            font-weight: bold;
            margin: 10px 0;
            color: #007BFF;
        }
        .stat-card .label {
            font-size: 14px;
            color: #777;
        }
        .dashboard-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: white;
            background-color: #ff4d4d;
            padding: 12px 18px;
            border-radius: 5px;
            font-weight: bold;
            box-shadow: 0 3px 8px rgba(255, 77, 77, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            z-index: 100;
        }
        .dashboard-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 77, 77, 0.5);
        }
        .dashboard-btn i {
            margin-right: 8px;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #f0f4f7;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(0, 123, 255, 0.2);
            border-top-color: #007BFF;
            border-radius: 50%;
        }
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float-animation {
            animation: floating 3s ease-in-out infinite;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner" id="spinner"></div>
</div>

<a href="Doctor Dashbord.html" class="dashboard-btn">
    <i class="fas fa-home"></i>  Dashboard
</a>

<div class="container" data-aos="fade-up">
    <h2 class="text-animation">Appointment Visualization</h2>
    
    <div class="stats-container">
        <div class="stat-card" id="totalCard">
            <div class="label"><i class="fas fa-calendar-check"></i> Total Appointments</div>
            <div class="value" id="totalValue"><?php echo $total_appointments; ?></div>
        </div>
        <div class="stat-card" id="avgCard">
            <div class="label"><i class="fas fa-user-md"></i> Avg. per Doctor</div>
            <div class="value" id="avgValue"><?php echo number_format($total_appointments / count($doctor_data), 1); ?></div>
        </div>
        <div class="stat-card" id="branchesCard">
            <div class="label"><i class="fas fa-hospital"></i> Active Branches</div>
            <div class="value" id="branchesValue"><?php echo count($branch_labels); ?></div>
        </div>
    </div>
    
    <div id="chartContainer">
        <div class="chart-wrapper float-animation" data-aos="zoom-in">
            <div class="chart-title"><i class="fas fa-chart-pie"></i> Distribution by Branch</div>
            <canvas id="branchChart"></canvas>
        </div>
        
        <div class="chart-wrapper" data-aos="zoom-in" data-aos-delay="300">
            <div class="chart-title"><i class="fas fa-chart-bar"></i> Appointments per Doctor</div>
            <canvas id="doctorChart"></canvas>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        anime({
            targets: '#spinner',
            rotate: 360,
            loop: true,
            duration: 800,
            easing: 'linear'
        });
        
        setTimeout(() => {
            anime({
                targets: '#loadingOverlay',
                opacity: 0,
                duration: 800,
                easing: 'easeOutQuad',
                complete: function() {
                    document.getElementById('loadingOverlay').style.display = 'none';
                }
            });
        }, 1500);
    });

    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            once: false
        });
      
        anime({
            targets: '.stat-card',
            translateY: 0,
            opacity: 1,
            delay: anime.stagger(200, {start: 500}),
            easing: 'easeOutElastic(1, .5)'
        });
        const totalValue = <?php echo $total_appointments; ?>;
        const avgValue = <?php echo $total_appointments / count($doctor_data); ?>;
        const branchesValue = <?php echo count($branch_labels); ?>;
        
        anime({
            targets: '#totalValue',
            innerHTML: [0, totalValue],
            round: 1,
            easing: 'easeInOutExpo',
            duration: 2000
        });
        
        anime({
            targets: '#avgValue',
            innerHTML: [0, avgValue],
            round: 10,
            easing: 'easeInOutExpo',
            duration: 2000
        });
        
        anime({
            targets: '#branchesValue',
            innerHTML: [0, branchesValue],
            round: 1,
            easing: 'easeInOutExpo',
            duration: 2000
        });
    });

    const branchCtx = document.getElementById('branchChart').getContext('2d');
    const branchData = {
        labels: <?php echo json_encode($branch_labels); ?>,
        datasets: [{
            label: 'Appointments by Branch',
            data: <?php echo json_encode($branch_data); ?>,
            backgroundColor: [
                'rgba(75, 192, 192, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2,
            hoverOffset: 15
        }]
    };

    const branchConfig = {
        type: 'doughnut',
        data: branchData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const percentage = Math.round((value / <?php echo $total_appointments; ?> * 100) * 10) / 10;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                },
                title: {
                    display: false
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                delay: function(context) {
                    return context.dataIndex * 300;
                }
            }
        },
    };

    const branchChart = new Chart(branchCtx, branchConfig);

    const doctorCtx = document.getElementById('doctorChart').getContext('2d');
    const doctorData = {
        labels: <?php echo json_encode($doctor_labels); ?>,
        datasets: [{
            label: 'Number of Appointments',
            data: <?php echo json_encode($doctor_data); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            borderRadius: 5,
            hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)'
        }]
    };

    const doctorConfig = {
        type: 'bar',
        data: doctorData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Appointments: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                delay: function(context) {
                    return context.dataIndex * 100;
                },
                duration: 1000,
                easing: 'easeOutQuart'
            }
        },
    };

    const doctorChart = new Chart(doctorCtx, doctorConfig);
  
    document.addEventListener('scroll', function() {
        AOS.refresh();
    });
</script>

</body>
</html>

<?php
$conn->close();
?>