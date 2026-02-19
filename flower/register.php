<?php
global $conn;
@include 'config.php';

$message = [];

if (isset($_POST['submit'])) {

    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $raw_pass = $_POST['pass']; // استخدم كلمة السر الأصلية للتحقق من الطول
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));

    $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
    $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

    // التحقق من الطول
    if (strlen($raw_pass) < 8) {
        $message[] = ['type' => 'error', 'text' => 'Password must be at least 8 characters long!'];
    } else {
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($select_users) > 0) {
            $message[] = ['type' => 'error', 'text' => 'This email is already registered!'];
        } else {
            if ($pass != $cpass) {
                $message[] = ['type' => 'error', 'text' => 'Passwords do not match!'];
            } else {
                mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
                $message[] = ['type' => 'success', 'text' => 'Registration successful! You can now log in.'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Flower Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Lora', serif;
            background-color: #ffffff;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .left {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #6a0dad;
            color: white;
            padding: 40px;
            text-align: center;
            border-top-right-radius: 200px;
            border-bottom-right-radius: 200px;
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 2;
            transition: all 0.8s cubic-bezier(0.65, 0, 0.35, 1);
        }

        .left h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .left p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .left button {
            padding: 12px 20px;
            background-color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            color: #6a0dad;
            transition: 0.3s;
        }

        .left button:hover {
            background-color: #6a0dad;
            color: white;
        }

        .right {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            padding: 40px;
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 1;
        }

        .form-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        h1 {
            color: #6a0dad;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1em;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        input[type="submit"] {
            background-color: #6a0dad;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #5a0c8d;
            transform: scale(1.05);
        }

        .footer-text {
            margin-top: 20px;
            font-size: 0.9em;
            text-align: center;
        }

        a {
            color: #6a0dad;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s ease-in-out;
        }

        .eye-icon:hover {
            color: #6a0dad;
        }

        .full-cover {
            width: 100%;
            border-radius: 0;
            transform: translateX(0);
        }

        .hidden {
            opacity: 0;
            transition: opacity 0.4s ease 0.4s;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #ffcccc;
            background-color: #ffeeee;
            border-radius: 5px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #ccffcc;
            background-color: #eeffee;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="left" id="leftPanel">
        <div>
            <h2>Welcome Back</h2>
            <p>Already have an account?</p>
            <button id="loginBtn">Login</button>
        </div>
    </div>

    <div class="right" id="rightPanel">
        <div class="form-container" id="formContainer">
            <h1>Sign Up</h1>
            <p>Welcome to our Flower Shop. Sign up to explore our exclusive collection of fresh flowers and special offers!</p>

            <?php if (!empty($message)): ?>
                <div class="<?= $message[0]['type'] === 'success' ? 'success-message' : 'error-message' ?>">
                    <?= $message[0]['text']; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" name="name" id="name" required placeholder="Choose a unique username">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" required placeholder="e.g., example@email.com">
                </div>
                <div class="form-group password-container">
                    <label for="pass">Password</label>
                    <input type="password" name="pass" id="pass" required placeholder="Enter password">
                    <span class="eye-icon" onclick="togglePassword('pass', 'eyeIcon')"><i class="fas fa-eye-slash" id="eyeIcon"></i></span>
                </div>
                <div class="form-group password-container">
                    <label for="cpass">Confirm Password</label>
                    <input type="password" name="cpass" id="cpass" required placeholder="Confirm Password">
                    <span class="eye-icon" onclick="togglePassword('cpass', 'confirmEyeIcon')"><i class="fas fa-eye-slash" id="confirmEyeIcon"></i></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Create Account">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId, iconId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            field.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }

    document.getElementById('loginBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const leftPanel = document.getElementById('leftPanel');
        const formContainer = document.getElementById('formContainer');
        leftPanel.classList.add('full-cover');
        formContainer.classList.add('hidden');
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 800);
    });
</script>

</body>
</html>
