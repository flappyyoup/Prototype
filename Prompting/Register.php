<!-- filepath: c:\Users\jed ismael polong\Documents\Propting the Project\Register.php -->
<?php
// Include the database connection
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $mobile_number = $_POST['mobile_number'];
    $birth_date = $_POST['birth_date'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $sql = "INSERT INTO users (full_name, email, password, mobile_number, birth_date) 
                VALUES ('$full_name', '$email', '$hashed_password', '$mobile_number', '$birth_date')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            width: 1000px;
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
        
        .signup-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .form-group {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .form-group div {
            flex: 0 0 48%;
            display: flex;
            flex-direction: column;
            text-align: left;
        }
        
        label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #2e2e2e;
        }
        
        input {
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
            padding: 12px 200px;
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
        
        .login-text {
            margin-top: 15px;
            font-size: 14px;
            color: #000;
        }
        
        .login-text a {
            font-weight: bold;
            color: #000;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-text a:hover {
            color: #024d30;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="" class="signup-form">
            <div class="form-group">
                <div>
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Full Name" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <label for="mobile_number">Mobile Number</label>
                    <input type="text" id="mobile_number" name="mobile_number" placeholder="Mobile Number" required>
                </div>
                <div>
                    <label for="birth_date">Birth Date</label>
                    <input type="date" id="birth_date" name="birth_date" placeholder="Birth Date" required>
                </div>
            </div>
            <button type="submit" class="submit-btn">Register</button>
        </form>
        <div class="login-text">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>