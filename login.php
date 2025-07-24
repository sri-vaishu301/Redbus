<?php
include('db/config.php');
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $message = "✅ Login successful! Welcome, " . $user['username'] . ".";
            session_start();
            $_SESSION['loged'] = true;
            $_SESSION['my_name'] = $user['username'];

            header("Location: index.php");

        } else {
            $message = "❌ Incorrect password.";
        }
    } else {
        $message = "❌ Email not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #d61c1c;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #d61c1c;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .search-box {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #d61c1c;
        }

        .search-box input,
        .search-box button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .search-box button {
            background-color: #d61c1c;
            color: white;
            border: none;
            cursor: pointer;
        }

        .search-box button:hover {
            background-color: #a71818;
        }

        .forgot-password {
            text-align: right;
            margin: -5px 0 10px 0;
        }

        .forgot-password a {
            color: #1976d2;
            text-decoration: none;
            font-size: 14px;
        }

        footer {
            background-color: #d61c1c;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #00000066;
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            position: relative;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal-btn {
            margin-top: 15px;
            padding: 12px;
            background-color: #d61c1c;
            color: white;
            width: 100%;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .close-btn {
            position: absolute;
            right: 10px;
            top: 5px;
            font-size: 18px;
            cursor: pointer;
            color: #888;
        }

        .success-message, .error-message {
            text-align: center;
            margin: 15px auto;
            color: green;
        }

        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h1>Login to RedBus</h1>
    </header>

    <nav>
        <div style="font-size: 24px; font-weight: bold;">RedBus</div>
        <div>
            <a href="index.php">Home</a>
            <a href="poststory.php">Post Story</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        </div>
    </nav>

    <div class="search-box">
        <h2>Login</h2>

        <?php if ($message): ?>
            <p class="<?= strpos($message, '✅') === 0 ? 'success-message' : 'error-message' ?>">
                <?= $message ?>
            </p>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <p class="forgot-password">
                <a href="javascript:void(0);" onclick="openForgotModal()">Forgot Password?</a>
            </p>

            <button type="submit">Login</button>
        </form>

        <p style="text-align:center; font-size:14px; margin-top:10px;">
            Don't have an account? <a href="signup.php" style="color: #2467e4;">Sign up now</a>
        </p>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeForgotModal()">✖</span>
            <h2>Reset Password</h2>
            <input type="email" id="forgotEmail" placeholder="Enter your email">
            <input type="password" id="newPassword" placeholder="New password">
            <input type="password" id="confirmPassword" placeholder="Confirm password">
            <button class="modal-btn" onclick="submitReset()">Submit</button>
        </div>
    </div>

    <footer> 
        <p>© 2025 RedBus Clone | Designed by You</p>
        <p>Contact: support@redbusclone.com | 📞 +91 98765 43210</p>
    </footer>

    <script>
        function openForgotModal() {
            document.getElementById("forgotModal").style.display = "block";
        }

        function closeForgotModal() {
            document.getElementById("forgotModal").style.display = "none";
        }

        function submitReset() {
            const email = document.getElementById("forgotEmail").value.trim();
            const newPwd = document.getElementById("newPassword").value.trim();
            const confirmPwd = document.getElementById("confirmPassword").value.trim();

            if (!email || !newPwd || !confirmPwd) {
                alert("Please fill out all fields.");
                return;
            }

            if (newPwd !== confirmPwd) {
                alert("Passwords do not match.");
                return;
            }

            if (newPwd.length < 6) {
                alert("Password must be at least 6 characters.");
                return;
            }

            alert("✅ Password reset request sent for " + email);
            closeForgotModal();
        }
    </script>
</body>
</html>
