<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "hospital_management"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <title>Hospital Analytics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #1976D2;
            --secondary: #03A9F4;
            --accent: #4FC3F7;
            --light: #E1F5FE;
            --dark: #0D47A1;
            --success: #4CAF50;
            --warning: #FFC107;
            --danger: #F44336;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
        .navbar {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 100;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo {
            height: 50px;
            width: 50px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .site-title {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .user-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-name {
            font-weight: 500;
        }
        
        .dashboard-btn {
            background-color: red;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .dashboard-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .dashboard-title {
            font-size: 2.2rem;
            color: var(--dark);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .dashboard-title::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin: 5px 0;
        }
        
        .stat-label {
            font-size: 1rem;
            color: #666;
        }
        
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        
        .chart-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .chart-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 8px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
        }
        
        .chart-title {
            font-size: 1.3rem;
            color: var(--dark);
            margin-bottom: 20px;
            padding-left: 10px;
            border-left: 4px solid var(--primary);
        }
        
        canvas {
            width: 100% !important;
            height: auto !important;
            max-height: 300px;
        }
        
        .footer {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        
        .fade-in.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        @media (max-width: 768px) {
            .charts-container {
                grid-template-columns: 1fr;
            }
            
            .navbar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .user-nav {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
    <div class="logo-container">
        <img src="assets/Images/logonew.png" alt="Hospital Logo" class="logo">
            <h1>Care Compass Hospitals</h1>
        </div>
            <a href="Staff Dashbord.html" class="dashboard-btn">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-header">
            <h2 class="dashboard-title" data-aos="fade-up">Appointment Analytics Dashboard</h2>
        </div>
        
        <div class="stats-container">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-calendar-check stat-icon"></i>
                <div class="stat-value" id="totalAppointments"><?php echo $total_appointments; ?></div>
                <div class="stat-label">Total Appointments</div>
            </div>
            
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-hospital stat-icon"></i>
                <div class="stat-value" id="totalBranches"><?php echo count($branch_labels); ?></div>
                <div class="stat-label">Active Branches</div>
            </div>
            
            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-user-md stat-icon"></i>
                <div class="stat-value" id="totalDoctors"><?php echo count($doctor_labels); ?></div>
                <div class="stat-label">Active Doctors</div>
            </div>
        </div>
        
        <div class="charts-container">
            <div class="chart-card" data-aos="fade-right">
                <h3 class="chart-title">Appointments by Branch</h3>
                <canvas id="branchChart"></canvas>
            </div>
            
            <div class="chart-card" data-aos="fade-left">
                <h3 class="chart-title">Appointments by Doctor</h3>
                <canvas id="doctorChart"></canvas>
            </div>
        </div>
    </div>


    <script>
       
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            
            animateCounters();
        
            initializeCharts();
        });

        function animateCounters() {
            document.querySelectorAll('.stat-value').forEach(counter => {
                const target = parseInt(counter.innerText);
                const duration = 2000;
                const startTime = Date.now();
                const startValue = 0;
                
                function updateCounter() {
                    const currentTime = Date.now();
                    const elapsed = currentTime - startTime;
                    
                    if (elapsed < duration) {
                        const value = Math.ceil(startValue + (target - startValue) * (elapsed / duration));
                        counter.innerText = value;
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target;
                    }
                }
                
                updateCounter();
            });
        }
        
        function initializeCharts() {
            Chart.defaults.animation = {
                duration: 2000,
                easing: 'easeOutQuart'
            };
            
            const branchCtx = document.getElementById('branchChart').getContext('2d');
            const branchData = {
                labels: <?php echo json_encode($branch_labels); ?>,
                datasets: [{
                    label: 'Appointments by Branch',
                    data: <?php echo json_encode($branch_data); ?>,
                    backgroundColor: [
                        'rgba(25, 118, 210, 0.7)',
                        'rgba(3, 169, 244, 0.7)',
                        'rgba(79, 195, 247, 0.7)',
                        'rgba(79, 175, 80, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(244, 67, 54, 0.7)'
                    ],
                    borderColor: [
                        'rgba(25, 118, 210, 1)',
                        'rgba(3, 169, 244, 1)',
                        'rgba(79, 195, 247, 1)',
                        'rgba(79, 175, 80, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(244, 67, 54, 1)'
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
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        title: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            padding: 12,
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 14
                            }
                        }
                    }
                }
            };

            const branchChart = new Chart(branchCtx, branchConfig);

            const doctorCtx = document.getElementById('doctorChart').getContext('2d');
            
            const gradientFill = doctorCtx.createLinearGradient(0, 0, 0, 400);
            gradientFill.addColorStop(0, 'rgba(79, 195, 247, 0.8)');
            gradientFill.addColorStop(1, 'rgba(3, 169, 244, 0.2)');
            
            const doctorData = {
                labels: <?php echo json_encode($doctor_labels); ?>,
                datasets: [{
                    label: 'Appointments',
                    data: <?php echo json_encode($doctor_data); ?>,
                    backgroundColor: gradientFill,
                    borderColor: 'rgba(3, 169, 244, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }]
            };

            const doctorConfig = {
                type: 'bar',
                data: doctorData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            padding: 12,
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 14
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            };

            const doctorChart = new Chart(doctorCtx, doctorConfig);
            
            document.querySelectorAll('.chart-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    anime({
                        targets: this,
                        translateY: -5,
                        boxShadow: '0 15px 30px rgba(0,0,0,0.15)',
                        duration: 300,
                        easing: 'easeOutQuad'
                    });
                });
                
                card.addEventListener('mouseleave', function() {
                    anime({
                        targets: this,
                        translateY: 0,
                        boxShadow: '0 8px 16px rgba(0,0,0,0.1)',
                        duration: 300,
                        easing: 'easeOutQuad'
                    });
                });
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
        
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>