<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "hospital_management"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nic = '';
$doctor_id = '';
$branch = '';
$start_date = '';
$end_date = '';
$search_query = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nic = $_POST['nic'];
    $doctor_id = $_POST['doctor_id'];
    $branch = $_POST['branch'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $search_query = "SELECT id, doctor_id, patient_name, nic, birthday, phone_number, address, appointment_date 
                     FROM appointments WHERE 1=1";

    if (!empty($nic)) {
        $search_query .= " AND nic = ?";
    }
    if (!empty($doctor_id)) {
        $search_query .= " AND doctor_id = ?";
    }
    if (!empty($branch)) {
        $search_query .= " AND branch = ?";
    }
    if (!empty($start_date) && !empty($end_date)) {
        $search_query .= " AND appointment_date BETWEEN ? AND ?";
    }

    $stmt = $conn->prepare($search_query);

    if (!empty($nic) && !empty($doctor_id) && !empty($branch) && !empty($start_date) && !empty($end_date)) {
        $stmt->bind_param("sssss", $nic, $doctor_id, $branch, $start_date, $end_date);
    } elseif (!empty($nic) && !empty($doctor_id) && !empty($branch)) {
        $stmt->bind_param("sss", $nic, $doctor_id, $branch);
    } elseif (!empty($nic) && !empty($start_date) && !empty($end_date)) {
        $stmt->bind_param("ssss", $nic, $start_date, $end_date);
    } elseif (!empty($doctor_id) && !empty($branch)) {
        $stmt->bind_param("ss", $doctor_id, $branch);
    } elseif (!empty($nic)) {
        $stmt->bind_param("s", $nic);
    } elseif (!empty($doctor_id)) {
        $stmt->bind_param("s", $doctor_id);
    } elseif (!empty($branch)) {
        $stmt->bind_param("s", $branch);
    } elseif (!empty($start_date) && !empty($end_date)) {
        $stmt->bind_param("ss", $start_date, $end_date);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT id, doctor_id, patient_name, nic, birthday, phone_number, address, appointment_date FROM appointments");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        :root {
            --primary: #1a73e8;
            --secondary: #34a853;
            --accent: #1b998b;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --danger: #ea4335;
            --warning: #fbbc05;
            --success: #0f9d58;
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

        .header {
            background: linear-gradient(90deg, var(--primary), var(--accent));
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .logo i {
            font-size: 32px;
            color: var(--primary);
        }

        .title h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .title p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .dashboard-btn {
            text-decoration: white;
            background-color: red;
            color: white;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container-header {
            background: linear-gradient(to right, var(--primary), var(--accent));
            padding: 20px 30px;
            color: white;
        }

        .container-header h1 {
            margin: 0;
            font-size: 1.8rem;
            position: relative;
            display: inline-block;
        }

        .container-header h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: white;
            border-radius: 3px;
        }

        .search-form {
            padding: 25px 30px;
            background: var(--light);
            border-bottom: 1px solid #e1e5eb;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark);
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5eb;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            background-color: white;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus, 
        .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.15);
        }

        .form-group i {
            position: absolute;
            right: 12px;
            top: 38px;
            color: #9aa0a6;
        }

        .search-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: background 0.3s, transform 0.3s;
            height: 45px;
            margin-top: 30px;
        }

        .search-btn:hover {
            background: #0b5fcb;
            transform: translateY(-2px);
        }

        .search-btn i {
            font-size: 1.1rem;
        }

        .table-container {
            padding: 20px 30px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        thead {
            background: var(--primary);
            color: white;
        }

        th {
            text-align: left;
            padding: 15px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            color: var(--dark);
        }

        tbody tr {
            background-color: white;
            transition: background-color 0.3s;
        }

        tbody tr:hover {
            background-color: #f7faff;
            transform: scale(1.01);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

       
        .animate-row {
            opacity: 0;
            transform: translateX(-20px);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #5f6368;
        }

        .empty-state i {
            font-size: 3rem;
            color: #dadce0;
            margin-bottom: 15px;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        @media screen and (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 15px;
                gap: 15px;
            }

            .logo-container {
                width: 100%;
                justify-content: center;
            }

            .user-actions {
                width: 100%;
                justify-content: center;
            }

            .container {
                margin: 15px;
                border-radius: 8px;
            }

            .search-form {
                grid-template-columns: 1fr;
                padding: 15px;
            }

            .table-container {
                padding: 15px;
            }

            td, th {
                padding: 10px 12px;
                font-size: 0.85rem;
            }
        }

        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(26, 115, 232, 0.2);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: var(--dark);
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(26, 115, 232, 0.7);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(26, 115, 232, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(26, 115, 232, 0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }
    </style>
    
</head>

<body>
    <div class="loader">
        <div class="spinner"></div>
    </div>

    <div class="header animate__animated animate__fadeIn">
        <div class="logo-container">
            <div class="title">
                <h1>Care Compass Hospital</h1>
            </div>
        </div>
        <div class="user-actions">
            <p id="userFirstName" style="color: white; font-weight: 500;"></p>
            <a href="Doctor Dashbord.html" class="dashboard-btn">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="container">
        <div class="container-header">
            <h1 class="animate__animated animate__fadeInLeft">View Appointments</h1>
        </div>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="search-form" id="searchForm">
            <div class="form-group">
                <label for="nic"><i class="fas fa-id-card"></i> NIC</label>
                <input type="text" name="nic" id="nic" placeholder="Enter NIC" value="<?php echo htmlspecialchars($nic); ?>">
            </div>
            <div class="form-group">
                <label for="doctor_id"><i class="fas fa-user-md"></i> Doctor ID</label>
                <input type="text" name="doctor_id" id="doctor_id" placeholder="Enter Doctor ID" value="<?php echo htmlspecialchars($doctor_id); ?>">
            </div>
            <div class="form-group">
                <label for="branch"><i class="fas fa-hospital"></i> Branch</label>
                <select id="branch" name="branch">
                    <option value="">All Branches</option>
                    <option value="Colombo" <?php if ($branch == 'Colombo') echo 'selected'; ?>>Colombo</option>
                    <option value="Kandy" <?php if ($branch == 'Kandy') echo 'selected'; ?>>Kandy</option>
                    <option value="Galle" <?php if ($branch == 'Galle') echo 'selected'; ?>>Galle</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date"><i class="fas fa-calendar-alt"></i> Start Date</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
            </div>
            <div class="form-group">
                <label for="end_date"><i class="fas fa-calendar-alt"></i> End Date</label>
                <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
            </div>
            <button type="submit" class="search-btn" id="searchButton">
                <i class="fas fa-search"></i> Search
            </button>
        </form>

        <div class="table-container">
            <?php if ($result && $result->num_rows > 0): ?>
                <table id="appointmentsTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user-md"></i> Doctor ID</th>
                            <th><i class="fas fa-user"></i> Patient Name</th>
                            <th><i class="fas fa-id-card"></i> NIC</th>
                            <th><i class="fas fa-birthday-cake"></i> Birthday</th>
                            <th><i class="fas fa-phone"></i> Phone</th>
                            <th><i class="fas fa-map-marker-alt"></i> Address</th>
                            <th><i class="fas fa-calendar-check"></i> Appointment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count = 0;
                        while ($row = $result->fetch_assoc()): 
                            $count++;
                            $delay = $count * 100; 
                        ?>
                            <tr class="animate-row" data-delay="<?php echo $delay; ?>">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['doctor_id']; ?></td>
                                <td><?php echo $row['patient_name']; ?></td>
                                <td><?php echo $row['nic']; ?></td>
                                <td><?php echo $row['birthday']; ?></td>
                                <td><?php echo $row['phone_number']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['appointment_date']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state animate__animated animate__fadeIn">
                    <i class="fas fa-calendar-times"></i>
                    <p>No appointments found.</p>
                    <p>Try adjusting your search criteria.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
         
            $('.animate-row').each(function() {
                const delay = $(this).data('delay');
                const $row = $(this);
                
                setTimeout(function() {
                    $row.css({
                        'animation': 'fadeInLeft 0.5s ease forwards',
                        'opacity': '1',
                        'transform': 'translateX(0)'
                    });
                }, delay);
            });

            $('#searchForm').on('submit', function() {
                $('.loader').css('display', 'flex');
                return true;
            });

            $('.search-btn').hover(
                function() {
                    $(this).addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).removeClass('animate__animated animate__pulse');
                }
            );

            $('.form-group input, .form-group select').on('focus', function() {
                $(this).parent().find('label').css('color', '#1a73e8');
            }).on('blur', function() {
                $(this).parent().find('label').css('color', '');
            });

            $('.tooltip').hover(
                function() {
                    const tooltipText = $(this).data('tooltip');
                    const $tooltip = $('<span class="tooltiptext">' + tooltipText + '</span>');
                    $(this).append($tooltip);
                    
                    setTimeout(function() {
                        $tooltip.css('opacity', '1');
                    }, 10);
                },
                function() {
                    $(this).find('.tooltiptext').remove();
                }
            );

            // Date range validation
            $('#end_date').on('change', function() {
                const startDate = new Date($('#start_date').val());
                const endDate = new Date($(this).val());
                
                if (endDate < startDate) {
                    alert('End date cannot be earlier than start date');
                    $(this).val('');
                }
            });

            $('#appointmentsTable tbody tr').on('click', function() {
                $(this).toggleClass('highlight-row');
            });


            setInterval(function() {
                $('.logo').toggleClass('pulse');
            }, 3000);
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>