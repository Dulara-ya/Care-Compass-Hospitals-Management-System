<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "hospital_management"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$feedback_list = [];
$sql = "SELECT name, feedback_text, created_at FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedback_list[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback - Care Compass Hospitals</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #e6f2ff;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --light-bg: #f0f8ff;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        
        body {
            background-color: var(--background);
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCI+PHBhdGggZmlsbD0iI2JiZGVmYiIgZmlsbC1vcGFjaXR5PSIwLjIiIGQ9Ik0xMS44NjMgMTEuODYzYTEgMSAwIDAxMS40MTQgMGw3NS44NiA3NS44NmExIDEgMCAwMS0xLjQxNCAxLjQxNGwtNzUuODYtNzUuODZhMSAxIDAgMDEwLTEuNDE0eiIvPjxwYXRoIGZpbGw9IiNiYmRlZmIiIGZpbGwtb3BhY2l0eT0iMC4yIiBkPSJNMTEuODYzIDExLjg2M2ExIDEgMCAwMTEuNDE0IDBsNzUuODYgNzUuODZhMSAxIDAgMDEtMS40MTQgMS40MTRsLTc1Ljg2LTc1Ljg2YTEgMSAwIDAxMC0xLjQxNHoiIHRyYW5zZm9ybT0icm90YXRlKDkwLCA1MCwgNTApIi8+PC9zdmc+');
        }

        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo-container {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }

        header .logo {
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

        .nav-controls {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .back-button {
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            margin-left: 10px;
            display: flex;
            align-items: center;
        }

        .back-button:hover {
            background-color: #ff4d4d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .back-button i {
            margin-right: 5px;
        }

        main {
            margin-top: 100px;
            padding: 2rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        section {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.8s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feedback-item {
            background-color: var(--secondary-color);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: var(--transition);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            opacity: 0;
            transform: translateX(-20px);
        }

        .feedback-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        h2::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background-color: var(--accent-color);
            bottom: -10px;
            left: 25%;
            border-radius: 2px;
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .feedback-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #666;
            margin-top: 10px;
        }

        .feedback-text {
            text-align: left;
            line-height: 1.6;
        }

        .feedback-icon {
            color: var(--primary-color);
            margin-right: 8px;
        }

        .feedback-date {
            display: flex;
            align-items: center;
        }

        .no-feedback {
            padding: 2rem;
            color: #666;
            font-style: italic;
        }

        .refresh-button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            margin-top: 1rem;
            transition: var(--transition);
        }

        .refresh-button:hover {
            background-color: #0055aa;
        }

        @media (max-width: 768px) {
            main {
                padding: 1rem;
            }

            header {
                flex-direction: column;
                padding: 0.5rem;
            }

            header .logo-container {
                margin-bottom: 10px;
                margin-left: 0;
            }

            .nav-controls {
                margin-bottom: 10px;
                margin-right: 0;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo-container">
        <img src="assets/Images/logonew.png" alt="Hospital Logo" class="logo">
            <h1>Care Compass Hospitals - Feedback</h1>
        </div>
        <div class="nav-controls">
            <a href="Staff Dashbord.html" class="back-button">
                <i class="fas fa-home"></i>  Dashboard
            </a>
        </div>
    </header>

    <main>
        <section class="animate__animated animate__fadeIn">
            <h2><i class="fas fa-comments feedback-icon"></i>Submitted Feedback</h2>
            <div id="feedback-list">
                <?php if (count($feedback_list) > 0): ?>
                    <?php foreach ($feedback_list as $index => $feedback): ?>
                        <div class="feedback-item" id="feedback-<?php echo $index; ?>">
                            <div class="feedback-header">
                                <h4><i class="fas fa-user feedback-icon"></i><?php echo htmlspecialchars($feedback['name']); ?></h4>
                            </div>
                            <div class="feedback-text">
                                <?php echo htmlspecialchars($feedback['feedback_text']); ?>
                            </div>
                            <div class="feedback-meta">
                                <div class="feedback-date">
                                    <i class="far fa-calendar-alt feedback-icon"></i>
                                    <?php echo date('F j, Y, g:i a', strtotime($feedback['created_at'])); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-feedback">
                        <i class="fas fa-info-circle"></i> No feedback submissions yet.
                    </div>
                <?php endif; ?>
            </div>
            <button class="refresh-button" id="refresh-btn">
                <i class="fas fa-sync-alt"></i> Refresh Feedback
            </button>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation for feedback items
            const feedbackItems = document.querySelectorAll('.feedback-item');
            feedbackItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.15}s`;
                item.style.animation = 'fadeInUp 0.6s forwards';
            });

            // Get user name from localStorage or set a default
            const userName = localStorage.getItem('userFirstName') || 'Staff Member';
            document.getElementById('userFirstName').textContent = `Welcome, ${userName}`;

            // Refresh button functionality
            document.getElementById('refresh-btn').addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });

            // Add hover effect
            feedbackItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#d9eaff';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = 'var(--secondary-color)';
                });
            });
        });
    </script>
</body>
</html>