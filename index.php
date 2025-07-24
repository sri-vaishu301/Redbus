<?php
include('db/config.php');


session_start();

if(isset($_SESSION['loged'])){


$cabMsg = $busMsg = "";

// CAB FORM
if (isset($_POST['cab_submit'])) {
    $pickup = $_POST['pickup'];
    $drop = $_POST['drop'];
    $date = $_POST['date'];
    $type = $_POST['cabtype'];

    if ($pickup && $drop && $date && $type) {
        header("Location: searchcab.php?pickup=$pickup&drop=$drop&date=$date&type=$type");
        exit();
    } else {
        $cabMsg = "❌ Fill all cab fields.";
    }
}

// BUS HIRE FORM
if (isset($_POST['bus_submit'])) {
    $start = $_POST['start'];
    $dest = $_POST['dest'];
    $date = $_POST['hiredate'];
    $size = $_POST['busSize'];
    $amenities = $_POST['amenities'];
    $route = $_POST['route'];

    if ($start && $dest && $date && $size && $amenities && $route) {
        header("Location: searchhirebus.php?start=$start&dest=$dest&date=$date&size=$size&amenities=$amenities&route=$route");
        exit();
    } else {
        $busMsg = "❌ Fill all hire fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RedBus Clone - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background: whitesmoke;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #d61c1c;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .search-box {
            max-width: 90%;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px #d61c1c;
        }

        .search-box input,
        .search-box select,
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
            background-color: #a91111;
        }

        h1 {
            font-size: 1.8rem;
        }

        h2 {
            font-size: 1.5rem;
            text-align: center;
        }

        p {
            text-align: center;
        }

        @media (min-width: 768px) {
            h1 {
                font-size: 2.2rem;
            }

            h2 {
                font-size: 1.8rem;
            }

            .search-box {
                max-width: 600px;
            }

            .search-box input,
            .search-box select,
            .search-box button {
                font-size: 1.1em;
            }
        }

        @media (min-width: 992px) {
            .search-box {
                max-width: 700px;
            }
        }

        footer {
            background-color: #d61c1c;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }

        .imga {
            display: flex;
            margin: 10px auto;
            border-radius: 2px;
            width: 150px;
            height: 100px;
        }

        nav {
            background-color: #d12525;
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

        .hero {
            background-color: #f8d7da;
            padding: 50px 20px;
            text-align: center;
        }
        
        /* Chatbot Styles */
        .chat-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #d61c1c;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            z-index: 999;
            box-shadow: 0 2px 8px #d61c1c;
        }

        .chatbot {
            position: fixed;
            bottom: 80px;
            right: 20px;
            background: white;
            width: 320px;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 4px 12px #d61c1c;
            z-index: 998;
            display: none;
        }

        .chatbot img {
            display: block;
            margin: 0 auto 10px;
            height: 40px;
        }

        .chatbot .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .chatbot .greeting {
            text-align: center;
            margin: 10px 0;
            color: #d61c1c;
            font-weight: bold;
        }

        .chatbot .subtitle {
            text-align: center;
            background: #e3f2fd;
            padding: 5px;
            border-radius: 10px;
            color: #d61c1c;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .chatbot input,
        .chatbot select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .chatbot button {
            width: 100%;
            background: #d61c1c;
            color: white;
            border: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .response {
            margin-top: 10px;
            padding: 10px;
            background: #f1f1f1;
            border-radius: 8px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<header>
    <h1>RedBus</h1>
    <img class="imga" src="https://businessparkcenter.com/wp-content/uploads/2024/09/Redbus.webp" alt="RedBus Logo">
</header>

<nav>
    <div style="font-size: 24px; font-weight: bold;">RedBus Clone</div>
    <div>
        <a href="index.php">Home</a>
        <a href="poststory.php">Post Story</a>
        <a href="login.php">Login</a>
        <a href="signup.php">Sign Up</a>
    </div>
</nav>

<section class="hero">
    <h1> <?= $_SESSION['my_name'] ?> Welcome to RedBus Clone</h1>
    <p>Your one-stop destination for booking buses, cabs, and sharing travel experiences.</p>
</section>

<div class="search-box">
    <h2>Search Buses</h2>
    <form method="GET" action="searchbuses.php">
        <input type="text" name="from" placeholder="From (e.g. Chennai)">
        <input type="text" name="to" placeholder="To (e.g. Bangalore)">
        <input type="date" name="date">
        <button type="submit" name="buses_submit">Search Buses</button>
    </form>
</div>

<div class="search-box">
    <h2>Cab Rental</h2>
    <form method="POST">
        <input type="text" name="pickup" placeholder="Pickup Location">
        <input type="text" name="drop" placeholder="Drop Location">
        <input type="date" name="date">
        <select name="cabtype">
            <option value="">Select Cab Type</option>
            <option value="sedan">Sedan</option>
            <option value="suv">SUV</option>
            <option value="mini">Mini</option> 
        </select>
        <button type="submit" name="cab_submit">Search Cab</button>
    </form>
    <?php if ($cabMsg): ?>
        <p style="color:<?= strpos($cabMsg, '✅') === 0 ? 'green' : 'red' ?>;"><?= $cabMsg ?></p>
    <?php endif; ?>
</div>

<div class="search-box">
    <h2>Bus Hiring</h2>
    <form method="POST">
        <input type="text" name="start" placeholder="Start Location">
        <input type="text" name="dest" placeholder="Destination">
        <input type="date" name="hiredate">
        <select name="busSize">
            <option value="">Select Bus Size</option>
            <option value="20">20 Seater</option>
            <option value="30">30 Seater</option>
            <option value="50">50 Seater</option>
        </select>
        <select name="amenities">
            <option value="">Select Amenities</option>
            <option value="ac">AC</option>
            <option value="non-ac">Non-AC</option>
            <option value="luxury">Luxury</option>
        </select>
        <textarea name="route" placeholder="Custom Route / Notes"></textarea>
        <button type="submit" name="bus_submit">Search Hire Bus</button>
    </form>
    <?php if ($busMsg): ?>
        <p style="color:<?= strpos($busMsg, '✅') === 0 ? 'green' : 'red' ?>;"><?= $busMsg ?></p>
    <?php endif; ?>
</div>

<div class="search-box">
    <h2>🚀 New Features</h2>
    <ul style="padding-left: 20px;">
        <li>Live seat selection for buses</li>
        <li>Filter by amenities (AC, Wi-Fi, etc.)</li>
        <li>User review & rating system</li>
        <li>24x7 Chatbot Assistant</li>
    </ul>
</div>

   <!-- Floating Chatbot -->
   <button class="chat-toggle" onclick="toggleChat()">💬</button>
    <div class="chatbot" id="chatbotBox">
        <img src="https://businessparkcenter.com/wp-content/uploads/2024/09/Redbus.webp" alt="RedBus Logo" width="75">
        <div class="title">RedBus Assistant</div>
        <div class="greeting">👋 Hey there!</div>
        <div class="subtitle">I'm your RedBus assistant</div>
        <select id="dropdown" onchange="fillInput()">
            <option value="">Select a question to search...</option>
            <option>How do book cab rental?</option>
            <option>What are the bus available?</option>
            <option>How do book bus hiring?</option>
            <option>How do I submit travel story?</option>
        </select>
        <input type="text" id="questionInput" placeholder="select any one question above...">
        <button onclick="submitQuestion()">Send</button>
        <div class="response" id="responseBox"></div>
    </div>

    <footer style="background-color:#d61c1c; color:white; text-align:center; padding:20px; margin-top:30px;">
        <p>© 2025 RedBus Clone | Designed by You</p>
        <p>Contact: support@redbusclone.com | 📞 +91 98765 43210</p>
    </footer>

    <script>

        function bus_submit() {
            const pickup = document.getElementById("pickup").value;
            const drop = document.getElementById("drop").value;
            const date = document.getElementById("busdate").value;
            const cab = document.getElementById("cabtype").value;
            if (!pickup || !drop || !date || !cab) {
                alert("Please fill all fields ");
                return;
            }
            window.location.href = `searchcab.php?cabtype=${cab}`;
        }
        function fillInput() {
            const dropdown = document.getElementById("dropdown");
            const input = document.getElementById("questionInput");
            input.value = dropdown.value;
        }

        function submitQuestion() {
            const question = document.getElementById("questionInput").value.trim();
            const responseBox = document.getElementById("responseBox");
            const answers = {
                "How do book cab rental?": "Visit your dashboard and fill the cab rental section then click cab rental button to submit.",
                "What are the bus available?": "Fill the From and To fields, select a date, and click 'Search Buses'.",
                "How do book bus hiring?": "Go to Bus Hiring section, fill all details and click the Hire Bus button.",
                "How do I submit travel story?": "Scroll to the Travel Community section, write your story and click 'Post Story'."
            };
            if (answers[question]) {
                responseBox.innerText = answers[question];
            } else {
                responseBox.innerText = "Sorry, I couldn't understand that. Please select a valid question.";
            }
        }

        function toggleChat() {
            const chatbotBox = document.getElementById("chatbotBox");
            chatbotBox.style.display = chatbotBox.style.display === "none" || chatbotBox.style.display === "" ? "block" : "none";
        }
    </script>
</body>
</html>
<?php
}
else{
    header("Location: login.php");
}
?>