<?php
// Include the database connection
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid email or password!');</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fedc56;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffc300;
            padding: 40px;
            border-radius: 20px;
            width: 400px;
            box-sizing: border-box;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        h2 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #000;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group {
            width: 100%;
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #2e2e2e;
        }

        input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 12px;
            transition: box-shadow 0.3s ease;
        }

        input:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .submit-btn {
            background-color: #024d30;
            color: #fff;
            border: none;
            padding: 12px 100px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #016f3e;
            transform: scale(1.05);
        }

        .register-text {
            margin-top: 15px;
            font-size: 14px;
            color: #000;
        }

        .register-text a {
            font-weight: bold;
            color: #000;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-text a:hover {
            color: #024d30;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
        <div class="register-text">
            <p>Don't have an account? <a href="Register.php">Register</a></p>
        </div>
    </div>
</body>
</html>