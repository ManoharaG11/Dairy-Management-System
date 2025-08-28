<?php
include 'db.php'; // Include the database connection
session_start();

// If the customer is already logged in, redirect to their dashboard
if (isset($_SESSION['customer_email'])) {
    header("Location: customer_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch customer details from the database
    $sql = "SELECT * FROM Customers WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $customer = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $customer['Password'])) {
            // Set session for customer
            $_SESSION['customer_email'] = $customer['Email'];
            header("Location: customer_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('No account found with that email!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff6f61, #ff8a00);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            overflow: hidden;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
            backdrop-filter: blur(10px);
        }

        .login-container h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .login-container input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1.5rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            outline: none;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .login-container input:focus {
            background: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        .login-container button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #1e90ff, #4682b4);
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-container button:hover {
            background: linear-gradient(90deg, #4682b4, #1e90ff);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .login-container p {
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .login-container p a {
            color: #87cefa;
            text-decoration: none;
            font-weight: bold;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Customer Login</h2>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="customer_register.php">Register here</a>.</p>
    </div>
</body>
</html>
