<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feedback'])) {
    $name = $_POST['name'];
    $feedback_text = $_POST['feedback_text'];

    $sql = "INSERT INTO feedback (name, feedback_text) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $feedback_text);

    if ($stmt->execute()) {
        echo "<script>alert('Feedback submitted successfully! Thank you for your input.');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
    $query_name = $_POST['query-name'];
    $query_email = $_POST['query-email'];
    $query_text = $_POST['query-text'];

    $sql = "INSERT INTO queries (name, email, query_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $query_name, $query_email, $query_text);

    if ($stmt->execute()) {
        echo "<script>alert('Query submitted successfully! We will get back to you shortly.');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
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
    <title>Care Compass Hospitals</title>
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #e6f2ff;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --light-bg: #f0f8ff;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            overflow-x: hidden;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes floatAnimation {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
        }
        
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        
        .animate-slide-in {
            animation: slideInRight 0.8s ease forwards;
            opacity: 0;
        }
        
        .animate-float {
            animation: floatAnimation 4s ease-in-out infinite;
        }
        
        .delay-1 {
            animation-delay: 0.2s;
        }
        
        .delay-2 {
            animation-delay: 0.4s;
        }
        
        .delay-3 {
            animation-delay: 0.6s;
        }
        
        .delay-4 {
            animation-delay: 0.8s;
        }
        
        .delay-5 {
            animation-delay: 1s;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        header.scrolled {
            padding: 0.7rem 1rem;
            background-color: rgba(0, 102, 204, 0.95);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        .logo img {
            height: 40px;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        
        .logo:hover img {
            transform: rotate(10deg);
        }
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .auth-button {
            background-color: white;
            color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.2rem;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 25px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        
        .auth-button:hover {
            background-color: var(--accent-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        main {
            margin-top: 5rem;
            padding: 2rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        section {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            overflow: hidden;
        }
        
        section:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        h1, h2, h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        h2 {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }
        
        h2:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background-color: var(--accent-color);
            bottom: -8px;
            left: 0;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        
        section:hover h2:after {
            width: 100%;
        }
      
        .hero {
            background-image: url('assets/Images/new hospital.png');
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            margin-bottom: 2rem;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
            border-radius: 15px;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            padding: 2rem;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        
        .hero-button {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .hero-button:hover {
            background-color: white;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
   
        .services,
        .specialists,
        .branches {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
        }
        
        .service-item,
        .specialist-item,
        .branch-item {
            background-color: var(--secondary-color);
            border-radius: 15px;
            padding: 1.8rem;
            flex: 1 1 calc(33.333% - 2rem);
            min-width: 250px;
            transition: all 0.4s;
            text-align: center;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }
        
        .service-item::before,
        .specialist-item::before,
        .branch-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-color);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: right;
        }
        
        .service-item:hover::before,
        .specialist-item:hover::before,
        .branch-item:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .service-item:hover,
        .specialist-item:hover,
        .branch-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            background-color: white;
        }
        
        .service-item img,
        .specialist-item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-bottom: 1.5rem;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }
        
        .service-item:hover img,
        .specialist-item:hover img {
            transform: scale(1.1);
            border-color: var(--accent-color);
        }
        
        .feedback-item {
            background-color: var(--secondary-color);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            position: relative;
        }
        
        .feedback-item:hover {
            transform: translateX(10px);
            background-color: white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        
        .feedback-item::before {
            content: '"';
            position: absolute;
            font-size: 5rem;
            color: rgba(0, 102, 204, 0.1);
            top: -15px;
            left: 10px;
            font-family: Georgia, serif;
        }
        
        form {
            display: grid;
            gap: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        input,
        textarea,
        button[type="submit"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        input:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.2);
        }
        
        button[type="submit"] {
            background-color: var(--primary-color);
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        button[type="submit"]:hover {
            background-color: #0055aa;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Emergency Section */
        #emergency {
            background: linear-gradient(to right, #ffffff, #f0f8ff);
            position: relative;
            overflow: hidden;
        }
        
        #emergency::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background-color: rgba(255, 107, 107, 0.1);
            border-radius: 50%;
            bottom: -50px;
            right: -50px;
            z-index: 1;
        }
        
        .emergency-contact {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-top: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .emergency-contact h3 {
            color: white;
            margin-bottom: 0.5rem;
        }
        
        .hotline {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }
        
        .hotline:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
        
        .branch-contacts {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .branch-contact {
            flex: 1;
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .branch-contact:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            text-align: center;
            margin-top: 3rem;
            position: relative;
        }
        
        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .footer-column {
            flex: 1;
            min-width: 250px;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        .footer-column h3 {
            color: white;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        
        .footer-column ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-column ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-column ul li a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .footer-column ul li a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 1.5rem;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }
      
        .scroll-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            cursor: pointer;
            display: none;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            z-index: 999;
        }
        
        .scroll-top:hover {
            background-color: var(--accent-color);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }
        
        .scroll-top.show {
            display: block;
            animation: fadeInUp 0.5s ease;
        }
        
        @media (max-width: 768px) {
            .service-item,
            .specialist-item,
            .branch-item {
                flex: 1 1 calc(50% - 1.5rem);
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .auth-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .service-item,
            .specialist-item,
            .branch-item {
                flex: 1 1 100%;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            section {
                padding: 1.5rem;
            }
            
            main {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <header id="header">
        <nav>
            <div class="logo animate-fade-in-up">
                <img src="assets/Images/logonew.png" alt="Hospital Logo"> Care Compass Hospitals
            </div>
            <div class="auth-buttons">
                <a href="Login Page.php" class="auth-button animate-fade-in-up delay-1">Login</a>
                <a href="Registation from.php" class="auth-button animate-fade-in-up delay-2">Sign Up</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="hero">
            <div class="hero-content animate-fade-in-up">
                <h1>Welcome to Care Compass Hospitals</h1>
                <p>Providing exceptional healthcare across the nation</p>
                <a href="#services" class="hero-button animate-pulse">Explore Our Services</a>
            </div>
        </div>

        <section id="about" class="animate-fade-in-up">
            <h2>About Our Hospital</h2>
            <p>Care Compass Hospitals is a leading healthcare provider with three state-of-the-art branches across Sri Lanka. We are committed to delivering exceptional medical care and improving the health and well-being of our communities through advanced
                technology, compassionate staff, and patient-centered approach.</p>
        </section>

        <section id="services" class="animate-fade-in-up">
            <h2>Our Services</h2>
            <div class="services">
                <div class="service-item animate-fade-in-up delay-1">
                    <img src="assets/Images/General Medicine.png" alt="General Medicine" class="animate-float">
                    <h3>General Medicine</h3>
                    <p>Comprehensive care for various health conditions.</p>
                </div>
                <div class="service-item animate-fade-in-up delay-2">
                    <img src="assets/Images/Surgery.png" alt="Surgery" class="animate-float">
                    <h3>Surgery</h3>
                    <p>Advanced surgical procedures and post-operative care.</p>
                </div>
                <div class="service-item animate-fade-in-up delay-3">
                    <img src="assets/Images/Pediatrics.avif" alt="Pediatrics" class="animate-float">
                    <h3>Pediatrics</h3>
                    <p>Specialized care for infants, children, and adolescents.</p>
                </div>
                <div class="service-item animate-fade-in-up delay-4">
                    <img src="assets/Images/Obstetrics & Gynecology.webp" alt="Obstetrics & Gynecology" class="animate-float">
                    <h3>Obstetrics & Gynecology</h3>
                    <p>Complete women's health services.</p>
                </div>
                <div class="service-item animate-fade-in-up delay-5">
                    <img src="assets/Images/Cardiology.jpg" alt="Cardiology" class="animate-float">
                    <h3>Cardiology</h3>
                    <p>Heart disease diagnosis, treatment, and prevention.</p>
                </div>
                <div class="service-item animate-fade-in-up delay-5">
                    <img src="assets/Images/Orthopedics.jpg" alt="Orthopedics" class="animate-float">
                    <h3>Orthopedics</h3>
                    <p>Musculoskeletal care and joint replacements.</p>
                </div>
            </div>
        </section>

        <section id="specialists" class="animate-fade-in-up">
            <h2>Our Specialists</h2>
            <div class="specialists">
                <div class="specialist-item animate-slide-in delay-1">
                    <img src="assets/Images/Amara.png" alt="Dr. Amara Perera">
                    <h3>Dr. Amara Perera</h3>
                    <p>Chief of Surgery</p>
                </div>
                <div class="specialist-item animate-slide-in delay-2">
                    <img src="assets/Images/Nimal.png" alt="Dr. Nimal Fernando">
                    <h3>Dr. Nimal Fernando</h3>
                    <p>Head of Cardiology</p>
                </div>
                <div class="specialist-item animate-slide-in delay-3">
                    <img src="assets/Images/Samanthi.png" alt="Dr. Samanthi Silva">
                    <h3>Dr. Samanthi Silva</h3>
                    <p>Lead Pediatrician</p>
                </div>
            </div>
        </section>

        <section id="emergency" class="animate-fade-in-up">
            <h2>Emergency Services</h2>
            <p>We provide 24/7 emergency care at all our branches. Our emergency departments are equipped with the latest technology and staffed by experienced medical professionals ready to handle any medical crisis.</p>
            
            <div class="emergency-contact animate-pulse">
                <h3>Emergency Hotline</h3>
                <div class="hotline">1990</div>
            </div>
            
            <div class="branch-contacts">
                <div class="branch-contact animate-fade-in-up delay-1">
                    <h3>Colombo Branch</h3>
                    <p>Emergency Contact: +94 11 2345678</p>
                </div>
                <div class="branch-contact animate-fade-in-up delay-2">
                    <h3>Kandy Branch</h3>
                    <p>Emergency Contact: +94 81 2345678</p>
                </div>
                <div class="branch-contact animate-fade-in-up delay-3">
                    <h3>Galle Branch</h3>
                    <p>Emergency Contact: +94 91 2345678</p>
                </div>
            </div>

            <img src="assets/Images/emergencynew.png" alt="Emergency Department" style="width: 100%; height: auto; border-radius: 10px; margin-top: 1.5rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); transition: transform 0.3s;" class="animate-fade-in-up">
        </section>

        <section id="branches" class="animate-fade-in-up">
            <h2>Our Branches</h2>
            <div class="branches">
                <div class="branch-item animate-fade-in-up delay-1">
                    <h3>Colombo Branch</h3>
                    <p>123 Galle Road, Colombo 03</p>
                    <p>Phone: +94 11 2345678</p>
                </div>
                <div class="branch-item animate-fade-in-up delay-2">
                    <h3>Kandy Branch</h3>
                    <p>456 Peradeniya Road, Kandy</p>
                    <p>Phone: +94 81 2345678</p>
                </div>
                <div class="branch-item animate-fade-in-up delay-3">
                    <h3>Galle Branch</h3>
                    <p>789 Matara Road, Galle</p>
                    <p>Phone: +94 91 2345678</p>
                </div>
            </div>
        </section>

        <section id="feedback" class="animate-fade-in-up">
            <h2>Patient Feedback</h2>
            <div id="feedback-list">
                <?php foreach ($feedback_list as $index => $feedback): ?>
                    <div class="feedback-item animate-fade-in-up delay-<?php echo ($index % 5) + 1; ?>">
                        <h4><?php echo htmlspecialchars($feedback['name']); ?></h4>
                        <p><?php echo htmlspecialchars($feedback['feedback_text']); ?></p>
                        <small><?php echo date('F j, Y, g:i a', strtotime($feedback['created_at'])); ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
            <form id="feedback-form" method="POST" class="animate-fade-in-up">
                <h3>Submit Your Feedback</h3>
                <input type="text" name="name" placeholder="Your Name" required>
                <textarea name="feedback_text" placeholder="Your Feedback" rows="4" required></textarea>
                <button type="submit" name="feedback" class="animate-pulse">Submit Feedback</button>
            </form>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-column animate-fade-in-up">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#services">Our Services</a>