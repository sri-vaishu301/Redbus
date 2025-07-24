<?php
include('db/config.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $message = "✅ Signup successful!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "❌ Error in SQL syntax: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

        nav a:hover {
            text-decoration: underline;
        }

        .search-box {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #d61c1c;
        }

        .search-box h2 {
            text-align: center;
        }

        .search-box input,
        .search-box button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-box button {
            background-color: #d61c1c;
            color: white;
            border: none;
            cursor: pointer;
        }

        .search-box button:hover {
            background-color: #a91313;
        }

        footer {
            background-color: #d61c1c;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }

        .message {
            color: green;
            text-align: center;
            font-weight: bold;
        }

        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Signup to RedBus</h1>
    </header>

    <nav>
        <div><strong>RedBus</strong></div>
        <div>
            <a href="index.php">Home</a>
            <a href="poststory.php">Post Story</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        </div>
    </nav>

    <div class="search-box">
        <h2>Signup to Create Account</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Signup</button>
        </form>
        <?php if (!empty($message)): ?>
            <p class="<?= strpos($message, 'success') !== false ? 'message' : 'error' ?>">
                <?= $message ?>
            </p>
        <?php endif; ?>
    </div>

    <footer> 
        <p>© 2025 RedBus Clone | Designed by You</p>
        <p>Contact: support@redbusclone.com | 📞 +91 98765 43210</p>
    </footer>
</body>
</html>
