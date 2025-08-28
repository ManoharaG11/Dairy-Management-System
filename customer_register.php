<?php
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // Check if the email already exists
    $checkQuery = "SELECT * FROM Customers WHERE Email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "An account with this email already exists. Please <a href='customer_login.php'>login</a>.";
    } else {
        // Insert the new customer into the database
        $insertQuery = "INSERT INTO Customers (Name, Email, Password, Address, Contact) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $name, $email, $password, $address, $contact);

        if ($stmt->execute()) {
            echo "Registration successful! You can now <a href='customer_login.php'>login</a>.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff6f61, #ff8a00);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .register-container {
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

        .register-container h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .register-container label {
            display: block;
            text-align: left;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .register-container input {
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

        .register-container input:focus {
            background: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        .register-container button {
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

        .register-container button:hover {
            background: linear-gradient(90deg, #4682b4, #1e90ff);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .register-container p {
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .register-container p a {
            color: #87cefa;
            text-decoration: none;
            font-weight: bold;
        }

        .register-container p a:hover {
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
    <div class="register-container">
        <h2>Customer Registration</h2>
        <form method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="customer_login.php">Login here</a>.</p>
    </div>
</body>
</html>
