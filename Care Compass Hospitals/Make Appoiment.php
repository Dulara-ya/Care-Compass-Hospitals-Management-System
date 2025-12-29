<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "hospital_management"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branch = $_POST['branch'];
    $doctor_id = $_POST['doctor_id'];
    $patient_name = $_POST['patient_name'];
    $nic = $_POST['nic'];
    $birthday = $_POST['birthday'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $appointment_date = $_POST['appointment_date'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    $stmt = $conn->prepare("INSERT INTO appointments (branch, doctor_id, patient_name, nic, birthday, phone_number, address, appointment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $branch, $doctor_id, $patient_name, $nic, $birthday, $phone_number, $address, $appointment_date);

    if ($stmt->execute()) {
       
        $transaction_id = uniqid(); 
        $amount = 2500.00; 

      
        $stmt = $conn->prepare("INSERT INTO transactions (nic, amount, transaction_id, payment_status) VALUES (?, ?, ?, 'success')");
        $stmt->bind_param("sds", $nic, $amount, $transaction_id);
        $stmt->execute();

        echo "<div class='success-animation'>
                <div class='checkmark-circle'>
                    <div class='checkmark draw'></div>
                </div>
                <h3>Appointment Confirmed!</h3>
                <p>Your payment of Rs. 2,500 was processed successfully.</p>
              </div>";
        
      
        echo "<script>var bookingSuccess = true;</script>";
    } else {
        echo "<div class='error-message'>
                <div class='error-icon'>×</div>
                <p>Error: " . $stmt->error . "</p>
              </div>";
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
    <title>HealthCare Plus - Book Appointment</title>
    <style>
        :root {
            --primary: #1976D2;
            --primary-light: #BBDEFB;
            --primary-dark: #0D47A1;
            --accent: #00C853;
            --error: #F44336;
            --text: #333;
            --background: #F5F9FF;
            --card: #FFFFFF;
        }
        
        * {
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
        
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 12px;
            background-color: var(--card);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }
        
        h2 {
            text-align: center;
            color: var(--primary);
            font-size: 28px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
        }
        
        .form-section {
            margin-bottom: 25px;
            background-color: #f9fbff;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .section-title {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: var(--primary-dark);
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .form-column {
            flex: 1;
            min-width: 250px;
            padding: 0 10px;
        }
        
        label {
            display: block;
            margin: 10px 0 8px;
            font-weight: 500;
            color: var(--primary-dark);
            transition: transform 0.3s ease;
        }
        
        input:focus + label, select:focus + label {
            transform: translateY(-5px);
            color: var(--primary);
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 2px solid var(--primary-light);
            border-radius: 8px;
            font-size: 16px;
            background-color: white;
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.2);
            transform: translateY(-2px);
        }
        
        button {
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 6px rgba(25, 118, 210, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
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
                opacity: 1;
            }
            20% {
                transform: scale(25, 25);
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }
        
        button:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        
        button:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary));
            box-shadow: 0 6px 12px rgba(25, 118, 210, 0.3);
            transform: translateY(-2px);
        }
        
        .running-message {
            color: var(--error);
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background-color: rgba(244, 67, 54, 0.1);
            border-radius: 5px;
            border-left: 4px solid var(--error);
            font-weight: 500;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 0.8; }
            50% { opacity: 1; }
            100% { opacity: 0.8; }
        }
        
        .card-details {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #e7f3ff;
            border-left: 4px solid var(--primary);
            display: none;
            animation: fadeIn 0.5s ease-out;
        }
        
        .success-animation {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 30px 0;
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .checkmark-circle {
            width: 80px;
            height: 80px;
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin-bottom: 20px;
        }
        
        .checkmark-circle .background {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--accent);
            position: absolute;
        }
        
        .checkmark-circle .checkmark {
            border-radius: 5px;
        }
        
        .checkmark-circle .checkmark.draw:after {
            animation-delay: 100ms;
            animation-duration: 1s;
            animation-timing-function: ease;
            animation-name: checkmark;
            transform: scaleX(-1) rotate(135deg);
            animation-fill-mode: forwards;
        }
        
        .checkmark-circle .checkmark:after {
            opacity: 0;
            height: 40px;
            width: 20px;
            transform-origin: left top;
            border-right: 8px solid var(--accent);
            border-top: 8px solid var(--accent);
            border-radius: 2px !important;
            content: '';
            left: 25px;
            top: 45px;
            position: absolute;
        }
        
        @keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }
            20% {
                height: 0;
                width: 20px;
                opacity: 1;
            }
            40% {
                height: 40px;
                width: 20px;
                opacity: 1;
            }
            100% {
                height: 40px;
                width: 20px;
                opacity: 1;
            }
        }
        
        .error-message {
            display: flex;
            align-items: center;
            margin: 20px 0;
            padding: 15px;
            background-color: rgba(244, 67, 54, 0.1);
            border-radius: 8px;
            border-left: 4px solid var(--error);
            animation: shake 0.5s ease-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .error-icon {
            width: 30px;
            height: 30px;
            background-color: var(--error);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
            margin-right: 15px;
        }
        
        .dashboard-link {
            position: fixed;
            top: 20px;
            right: 20px;
            text-align: right;
            z-index: 100;
            animation: fadeIn 1s ease-out;
        }
        
        .dashboard-button {
            text-decoration: none;
            color: white;
            background: linear-gradient(45deg, #ff4d4d, #f44336);
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(244, 67, 54, 0.3);
            transition: all 0.3s ease;
        }
        
        .dashboard-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(244, 67, 54, 0.4);
        }
        
        .form-icon {
            color: var(--primary);
            margin-right: 10px;
        }
        
        .hospital-icon {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .hospital-logo {
            max-width: 120px;
            animation: pulse 3s infinite;
        }
    
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            
            .form-column {
                flex: 100%;
            }
            
            .dashboard-link {
                position: relative;
                top: 0;
                right: 0;
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-link">
        <p style="margin: 0; color: var(--primary);"><span id="userFirstName"></span></p>
        <a href="User Dashbord.html" class="dashboard-button">
            <i class="fas fa-home"></i> Go To Dashboard
        </a>
    </div>

    <div class="container">
        <div class="hospital-icon">
           
            <svg class="hospital-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                <rect x="35" y="20" width="30" height="60" fill="#1976D2" rx="2" />
                <rect x="25" y="30" width="50" height="50" fill="#BBDEFB" rx="2" />
                <rect x="40" y="10" width="20" height="10" fill="#1976D2" rx="2" />
                <rect x="45" y="30" width="10" height="10" fill="white" />
                <rect x="45" y="50" width="10" height="10" fill="white" />
                <rect x="30" y="40" width="10" height="10" fill="white" />
                <rect x="60" y="40" width="10" height="10" fill="white" />
                <rect x="40" y="70" width="20" height="10" fill="#0D47A1" />
            </svg>
        </div>
        
        <h2>Book Your Appointment</h2>
        
        <form method="POST" action="" id="appointmentForm">
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-hospital"></i>
                    <h3>Appointment Details</h3>
                </div>
                
                <div class="form-row">
                    <div class="form-column">
                        <label for="branch"><i class="fas fa-building form-icon"></i> Select Branch:</label>
                        <select id="branch" name="branch" required>
                            <option value="Colombo">Colombo</option>
                            <option value="Kandy">Kandy</option>
                            <option value="Galle">Galle</option>
                        </select>
                    </div>
                    
                    <div class="form-column">
                        <label for="doctor"><i class="fas fa-user-md form-icon"></i> Select Doctor:</label>
                        <select id="doctor" name="doctor_id" required>
                            <option value="">Select a doctor</option>
                            <?php
                            
                            $servername = "localhost"; 
                            $username = "root"; 
                            $password = ""; 
                            $dbname = "hospital_management"; 

                            
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            
                            $sql = "SELECT id, name FROM doctors";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                                }
                            } else {
                                echo "<option value=''>No doctors available</option>";
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    <h3>Patient Information</h3>
                </div>
                
                <div class="form-row">
                    <div class="form-column">
                        <label for="patient_name"><i class="fas fa-user form-icon"></i> Patient Name:</label>
                        <input type="text" id="patient_name" name="patient_name" required>
                    </div>
                    
                    <div class="form-column">
                        <label for="nic"><i class="fas fa-id-card form-icon"></i> NIC:</label>
                        <input type="text" id="nic" name="nic" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-column">
                        <label for="birthday"><i class="fas fa-birthday-cake form-icon"></i> Birthday:</label>
                        <input type="date" id="birthday" name="birthday" required>
                    </div>
                    
                    <div class="form-column">
                        <label for="phone_number"><i class="fas fa-phone form-icon"></i> Phone Number:</label>
                        <input type="text" id="phone_number" name="phone_number" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-column">
                        <label for="address"><i class="fas fa-home form-icon"></i> Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    
                    <div class="form-column">
                        <label for="date"><i class="fas fa-calendar-alt form-icon"></i> Appointment Date and Time:</label>
                        <input type="datetime-local" id="date" name="appointment_date" required>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-credit-card"></i>
                    <h3>Payment Details</h3>
                </div>
                
                <div class="form-row">
                    <div class="form-column">
                        <label for="card_number"><i class="fas fa-credit-card form-icon"></i> Credit/Debit Card Number:</label>
                        <input type="text" id="card_number" name="card_number" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-column">
                        <label for="expiry_date"><i class="fas fa-calendar form-icon"></i> Expiry Date (MM/YY):</label>
                        <input type="text" id="expiry_date" name="expiry_date" required>
                    </div>
                    
                    <div class="form-column">
                        <label for="cvv"><i class="fas fa-lock form-icon"></i> CVV:</label>
                        <input type="text" id="cvv" name="cvv" required>
                    </div>
                </div>
            </div>
            
            <button type="submit" id="submitButton">
                <i class="fas fa-calendar-check"></i> Book Appointment
            </button>
            
            <div class="running-message">
                <i class="fas fa-info-circle"></i> Appointment charges are Rs. 2,500/= including lab fee and medical fee.
            </div>
        </form>
        
        <div class="card-details" id="cardDetails">
            <h3><i class="fas fa-credit-card"></i> Payment Details</h3>
            <p><strong>Card Number:</strong> <span id="displayCardNumber"></span></p>
            <p><strong>Expiry Date:</strong> <span id="displayExpiryDate"></span></p>
            <p><strong>CVV:</strong> <span id="displayCVV"></span></p>
        </div>
    </div>

    <script>
        
        window.addEventListener('load', function() {
           
            const formSections = document.querySelectorAll('.form-section');
            formSections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 100 + (index * 200));
            });
            
            
            if (typeof bookingSuccess !== 'undefined' && bookingSuccess) {
                document.getElementById('appointmentForm').style.display = 'none';
                confetti();
            }
        });
        
       
        function displayCardDetails(cardNumber, expiryDate, cvv) {
            document.getElementById('displayCardNumber').innerText = cardNumber;
            document.getElementById('displayExpiryDate').innerText = expiryDate;
            document.getElementById('displayCVV').innerText = cvv;
            document.getElementById('cardDetails').style.display = 'block';
        }
        
       
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;
                
                const ripple = document.createElement('span');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            let valid = true;
            const form = this;
            
            const cardNumber = document.getElementById('card_number').value;
            if (!/^\d{16}$/.test(cardNumber.replace(/\s/g, ''))) {
                alert('Please enter a valid 16-digit card number');
                valid = false;
            }
            
            const expiryDate = document.getElementById('expiry_date').value;
            if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
                alert('Please enter expiry date in MM/YY format');
                valid = false;
            }
            
           
            const cvv = document.getElementById('cvv').value;
            if (!/^\d{3,4}$/.test(cvv)) {
                alert('Please enter a valid CVV (3 or 4 digits)');
                valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
            } else {
                document.getElementById('submitButton').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                document.getElementById('submitButton').disabled = true;
            }
        });
        
        function confetti() {
            const canvas = document.createElement('canvas');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.pointerEvents = 'none';
            canvas.style.zIndex = '999';
            document.body.appendChild(canvas);
            
            const ctx = canvas.getContext('2d');
            const pieces = [];
            const colors = ['#1976D2', '#BBDEFB', '#00C853', '#E3F2FD', '#0D47A1'];
            
            for (let i = 0; i < 100; i++) {
                pieces.push({
                    x: Math.random() * canvas.width,
                    y: -Math.random() * canvas.height / 2,
                    size: Math.random() * 15 + 5,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    speed: Math.random() * 3 + 2,
                    angle: Math.random() * 360,
                    rotation: Math.random() * 10 - 5
                });
            }
            
            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                let allFallen = true;
                
                pieces.forEach(piece => {
                    ctx.save();
                    ctx.translate(piece.x, piece.y);
                    ctx.rotate(piece.angle * Math.PI / 180);
                    ctx.fillStyle = piece.color;
                    ctx.fillRect(-piece.size / 2, -piece.size / 2, piece.size, piece.size);
                    ctx.restore();
                    
                    piece.y += piece.speed;
                    piece.angle += piece.rotation;
                    
                    if (piece.y < canvas.height) {
                        allFallen = false;
                    }
                });
                
                if (!allFallen) {
                    requestAnimationFrame(animate);
                } else {
                    setTimeout(() => {
                        canvas.remove();
                    }, 1000);
                }
            }
            
            requestAnimationFrame(animate);
        }
        
        const inputFields = document.querySelectorAll('input, select, textarea');
        inputFields.forEach(field => {
            field.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            field.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>