<?php
@include 'config.php';
session_start();

// إذا تم إرسال النموذج
if (isset($_POST['submit'])) {
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
            exit;
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
            exit;
        } else {
            $_SESSION['error'] = 'No user found!';
            $_SESSION['prev_email'] = $email;
            header('location:login.php');
            exit;
        }

    } else {
        $_SESSION['error'] = 'Incorrect email or password!';
        $_SESSION['prev_email'] = $email;
        header('location:login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Flower Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Merriweather&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* تنسيق الصفحة كما هو تمامًا */
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
            flex-direction: row-reverse;
        }
        .right {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #6a0dad;
            color: white;
            padding: 40px;
            text-align: center;
            border-top-left-radius: 200px;
            border-bottom-left-radius: 200px;
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 2;
            transition: all 0.8s cubic-bezier(0.65, 0, 0.35, 1);
        }
        .right h2 { font-size: 2em; margin-bottom: 10px; }
        .right p { font-size: 1.2em; margin-bottom: 20px; }
        .right button {
            padding: 12px 20px;
            background-color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            color: #6a0dad;
            transition: 0.3s;
        }
        .right button:hover {
            background-color: #6a0dad;
            color: white;
            border: 1px solid white;
        }
        .left {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            padding: 40px;
            position: absolute;
            left: 0;
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
        .form-group { margin-bottom: 20px; }
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
            transition: border-color 0.3s ease, transform 0.3s ease;
        }
        input:focus {
            border-color: #6a0dad;
            box-shadow: 0 0 8px rgba(245, 167, 196, 0.6);
            transform: scale(1.02);
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
        input[type="submit"] {
            background-color: #6a0dad;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }
        input[type="submit"]:hover {
            background-color: #5a0c8d;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(245, 167, 196, 0.4);
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
        .remember-me {
            display: flex;
            align-items: center;
            margin-top: 15px;
            justify-content: flex-start;
        }
        .remember-me input {
            margin-right: 8px;
            width: auto;
            height: auto;
        }
        .remember-me label {
            font-size: 1em;
            color: #333;
        }
        #errorMessage {
            color: #f44336; /* نص باللون الأحمر */
            background-color: #ffebee; /* خلفية زهرية فاتحة */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ffcccc; /* حدود بلون زهري فاتح */
            font-size: 1.2em; /* زيادة حجم الخط */
            font-weight: 500; /* سمك الخط متوسط */
            font-family: 'Roboto', sans-serif; /* تغيير نوع الخط إلى Roboto */
        }





        .hidden {
            display: none;
        }
        .full-cover {
            width: 100% !important;
            border-radius: 0 !important;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Right Side (Sign Up Button) -->
    <div class="right" id="rightPanel">
        <div>
            <h2>Create Account</h2>
            <p>Don't have an account yet?</p>
            <button id="signupBtn">Sign Up</button>
        </div>
    </div>

    <!-- Left Side (Login Form) -->
    <div class="left" id="formContainer">
        <div class="form-container">
            <h1>Login</h1>
            <p>Welcome back to Flower Shop. Please log in to access your account and continue shopping!</p>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<div id="errorMessage">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="username" name="email" placeholder="Enter your email"
                           value="<?php echo isset($_SESSION['prev_email']) ? htmlspecialchars($_SESSION['prev_email']) : ''; ?>" required>
                    <?php unset($_SESSION['prev_email']); ?>
                </div>
                <div class="form-group password-container">
                    <label for="pass">Password</label>
                    <input type="password" id="pass" name="pass" placeholder="Enter your password" required>
                    <span class="eye-icon"><i class="fas fa-eye-slash" id="eyeIcon"></i></span>
                </div>
                <div class="remember-me">
                    <input type="checkbox" id="rememberMe" name="rememberMe">
                    <label for="rememberMe">Remember me</label>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Login">
                </div>
            </form>

<!--            <p class="footer-text">Forgot your password? <a href="reset-password.php">Reset Password</a></p>-->
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordField = document.getElementById('pass');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
        }
    }
    document.getElementById('eyeIcon').addEventListener('click', togglePassword);

    // Handle signup button animation and redirect
    document.getElementById('signupBtn').addEventListener('click', function (e) {
        e.preventDefault();
        const rightPanel = document.getElementById('rightPanel');
        const formContainer = document.getElementById('formContainer');
        rightPanel.classList.add('full-cover');
        formContainer.classList.add('hidden');
        setTimeout(function () {
            window.location.href = 'register.php';
        }, 800);
    });
</script>

</body>
</html>
