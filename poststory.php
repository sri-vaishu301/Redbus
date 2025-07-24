<?php
include('db/config.php');
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $story = trim($_POST['story']);
    if (!empty($story)) {
        $sql = "INSERT INTO stories (story) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $story);
        if ($stmt->execute()) {
            $message = "✅ Story posted successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "❌ Please enter a story.";
    }
}

// Fetch all stories
$storyList = [];
$result = $conn->query("SELECT * FROM stories ORDER BY created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $storyList[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Story</title>
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

        .search-box textarea,
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
            background-color: #b71717;
        }

        footer {
            background-color: #d61c1c;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }

        .story-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .story-meta {
            color: #999;
            font-size: 13px;
        }

        h2 {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h1>Travel Community</h1>
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
    <h2>Share Your Story</h2>

    <?php if ($message): ?>
        <p style="color:<?= strpos($message, '✅') === 0 ? 'green' : 'red' ?>; text-align:center;">
            <?= $message ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <textarea name="story" placeholder="Share your travel story, tips or photo link" rows="8" required></textarea>
        <button type="submit">Post Story</button>
    </form>
</div>

<h2>Community Stories</h2>
<div class="search-box">
    <?php if (count($storyList) === 0): ?>
        <p style="color:gray; text-align:center;">No stories yet. Be the first to post!</p>
    <?php else: ?>
        <?php foreach ($storyList as $story): ?>
            <div class="story-item">
                <p><?= nl2br(htmlspecialchars($story['story'])) ?></p>
                <div class="story-meta">Posted on <?= $story['created_at'] ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<footer>
    <p>© 2025 RedBus Clone | Designed by You</p>
    <p>Contact: support@redbusclone.com | 📞 +91 98765 43210</p>
</footer>

</body>
</html>
