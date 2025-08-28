<?php
// Start session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Dairy Delight</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e0f7fa, #b3e5fc);
            display: flex;
            flex-direction: column;
        }

        header {
            background: linear-gradient(120deg, #0288d1, #03a9f4);
            color: white;
            text-align: center;
            padding: 2rem 1rem;
            animation: fadeIn 2s ease-in-out;
        }

        header h1 {
            font-size: 3.5rem;
            letter-spacing: 4px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        header p {
            font-size: 1.6rem;
            margin-top: 1rem;
            font-style: italic;
        }

        nav {
            background: #0288d1;
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 1rem 0;
            animation: slideIn 1.5s ease-out;
        }

        nav a {
            text-decoration: none;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s;
        }

        nav a:hover {
            background: #81d4fa;
            color: #0288d1;
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
            color: #333;
        }

        main h2 {
            font-size: 3rem;
            color: #0288d1;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            animation: popIn 1.5s ease-out;
        }

        .about-container {
            max-width: 1000px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            gap: 3rem;
            padding: 1rem;
        }

        .about-text {
            max-width: 50%;
        }

        .about-image img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .about-text h3 {
            font-size: 2rem;
            color: #0288d1;
            margin-bottom: 1rem;
        }

        .about-text p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 1.5rem;
        }

        footer {
            background: linear-gradient(120deg, #81d4fa, #0288d1);
            text-align: center;
            color: white;
            padding: 1rem 0;
            animation: slideUp 1.5s ease-in-out;
        }

        footer p {
            font-size: 1rem;
            font-weight: 500;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        @keyframes popIn {
            from { transform: scale(0.5); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <header>
        <h1>Dairy Delight</h1>
        <p>Your Source of Fresh and Creamy Delights</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact</a>
        
    </nav>

    <main>
        <h2>About Us</h2>
        <div class="about-container">
            <div class="about-text">
                <h3>Our Mission</h3>
                <p>
                    At Dairy Delight, we are passionate about delivering premium, fresh, and nutritious dairy products that bring joy to your daily life.
                    We believe in sustainable farming practices, ethical sourcing, and creating products that not only taste great but also contribute to a healthy lifestyle.
                </p>

                <h3>Why Choose Us?</h3>
                <p>
                    We ensure the highest quality in all our products, sourced from trusted farms that share our commitment to freshness and sustainability. 
                    From milk to cheese, butter, and yogurt, every product is made with care and passion to provide the best tasting experience for you.
                </p>
            </div>

            <div class="about-image">
                <img src="my1.jpg" alt="Dairy Products" />
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date("Y"); ?> Dairy Delight. All Rights Reserved.</p>
    </footer>
</body>
</html>
