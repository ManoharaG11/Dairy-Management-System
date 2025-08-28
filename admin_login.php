<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Admin WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($admin['Password'] === $password) { // Password hashing recommended
            session_start();
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php");
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('Admin not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff7f50, #ff6347);
            color: white;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .login-container h1 {
            margin-bottom: 1rem;
            font-size: 2rem;
            text-transform: uppercase;
            color: #fff;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: #ddd;
        }

        .login-container input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1.5rem;
            border: none;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .login-container input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        .login-container button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 6px;
            background: linear-gradient(90deg, #ff7f50, #ff6347);
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .login-container button:hover {
            background: linear-gradient(90deg, #ff6347, #ff7f50);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .login-container button:active {
            transform: scale(1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
