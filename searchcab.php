<?php
include('db/config.php');
$results = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pickup = $_POST['pickup'];
    $drop = $_POST['drop'];
    $stmt = $conn->prepare("SELECT * FROM cab_bookings WHERE pickup LIKE ? AND drop_location LIKE ?");
    $pickupSearch = "%$pickup%";
    $dropSearch = "%$drop%";
    $stmt->bind_param("ss", $pickupSearch, $dropSearch);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head><title>Search Cab Bookings</title></head>
<body>
    <h2>Search Cab Bookings</h2>
    <form method="POST">
        <input type="text" name="pickup" placeholder="Pickup location">
        <input type="text" name="drop" placeholder="Drop location">
        <button type="submit">Search</button>
    </form>
    <hr>
    <?php if ($results): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr><th>Pickup</th><th>Drop</th><th>Type</th><th>Date</th></tr>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['pickup'] ?></td>
                    <td><?= $row['drop_location'] ?></td>
                    <td><?= $row['cab_type'] ?></td>
                    <td><?= $row['booking_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <p>No matching cab bookings found.</p>
    <?php endif; ?>
    <p><a href="index.php">← Back to Home</a></p>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cab Options</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .cab-card {
            background: #fff;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .cab-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cab-info img {
            width: 80px;
            height: auto;
        }

        .cab-details h3 {
            margin: 0;
        }

        .rating {
            background: #1abc9c;
            color: #fff;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            margin-left: 10px;
        }

        .cab-meta {
            color: #777;
            font-size: 14px;
        }

        .cab-footer {
            margin-top: 5px;
            font-size: 13px;
            color: #333;
        }

        .price-info {
            text-align: right;
            margin-top: 10px;
        }

        .old-price {
            text-decoration: line-through;
            color: gray;
            font-size: 14px;
        }

        .discount {
            color: green;
            font-size: 14px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
        }

        .taxes {
            font-size: 13px;
            color: gray;
        }

        .select-btn {
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .passenger-box {
            display: none;
            margin-top: 20px;
        }

        input {
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
        }

        .payment-box {
            display: none;
            margin-top: 15px;
        }

        button {
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- Cab 1 -->
    <div class="cab-card">
        <div class="cab-info">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoyWfyDQIPGQyS7wZAEnz4UV2eLQEPE6C1Bw&s"
                alt="Sedan">
            <div>
                <h3>MSV cab, Sedan <span class="rating">★ 4.5</span></h3>
                <div class="cab-meta">Diesel • 4 Seats • AC</div>
                <div class="cab-footer">Roof carrier available @ INR 209</div>
            </div>
        </div>
        <div class="price-info">
            <div class="discount">15% off <span class="old-price">₹7,780</span></div>
            <div class="price">₹6,650</div>
            <div class="taxes">+ ₹979 (Taxes & Charges)</div>
        </div>
        <button class="select-btn">APPLY NOW</button>
        <div class="passenger-box">
            <h3>Passenger Details</h3>
            <input type="text" placeholder="Full Name">
            <input type="tel" placeholder="Mobile Number">
            <input type="email" placeholder="Email Address">
            <button class="proceed-btn" onclick="proceedToPayment(this)">Proceed to Payment</button>
            <div class="payment-box">
                <h3>Payment</h3>
                <input type="text" placeholder="Card Number">
                <input type="text" placeholder="Name on Card">
                <input type="text" placeholder="Expiry (MM/YY)">
                <input type="text" placeholder="CVV">
                <button onclick="completePayment(this)">Pay Now</button>
            </div>
        </div>
    </div>

    <!-- Cab 2 -->
    <div class="cab-card">
        <div class="cab-info">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRvLvxrlNBWzw-ta-oZve5d2p2PR9zFx4uO-A&s"
                alt="SUV">
            <div>
                <h3>MSV cab, SUV <span class="rating">★ 4.5</span></h3>
                <div class="cab-meta">Diesel • 6 Seats • AC</div>
                <div class="cab-footer">Roof carrier available @ INR 262</div>
            </div>
        </div>
        <div class="price-info">
            <div class="discount">14% off <span class="old-price">₹11,061</span></div>
            <div class="price">₹9,485</div>
            <div class="taxes">+ ₹1,121 (Taxes & Charges)</div>
        </div>
        <button class="select-btn">APPLY NOW</button>
        <div class="passenger-box">
            <h3>Passenger Details</h3>
            <input type="text" placeholder="Full Name">
            <input type="tel" placeholder="Mobile Number">
            <input type="email" placeholder="Email Address">
            <button class="proceed-btn" onclick="proceedToPayment(this)">Proceed to Payment</button>
            <div class="payment-box">
                <h3>Payment</h3>
                <input type="text" placeholder="Card Number">
                <input type="text" placeholder="Name on Card">
                <input type="text" placeholder="Expiry (MM/YY)">
                <input type="text" placeholder="CVV">
                <button onclick="completePayment(this)">Pay Now</button>
            </div>
        </div>
    </div>

    <!-- Cab 3 -->
    <div class="cab-card">
        <div class="cab-info">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw1K9ujJmghJvEwJ-Hdrmu7JrWwlEX5vcNcA&s"
                alt="Innova">
            <div>
                <h3>Toyota Innova <span class="rating">★ 3.9</span></h3>
                <div class="cab-meta">Diesel • 7 Seats • AC</div>
                <div class="cab-footer">Roof carrier available @ INR 262</div>
            </div>
        </div>
        <div class="price-info">
            <div class="discount">14% off <span class="old-price">₹20,655</span></div>
            <div class="price">₹17,614</div>
            <div class="taxes">+ ₹1,490 (Taxes & Charges)</div>
        </div>
        <button class="select-btn">APPLY NOW</button>
        <div class="passenger-box">
            <h3>Passenger Details</h3>
            <input type="text" placeholder="Full Name">
            <input type="tel" placeholder="Mobile Number">
            <input type="email" placeholder="Email Address">
            <button class="proceed-btn" onclick="proceedToPayment(this)">Proceed to Payment</button>
            <div class="payment-box">
                <h3>Payment</h3>
                <input type="text" placeholder="Card Number">
                <input type="text" placeholder="Name on Card">
                <input type="text" placeholder="Expiry (MM/YY)">
                <input type="text" placeholder="CVV">
                <button onclick="completePayment(this)">Pay Now</button>
            </div>
        </div>
    </div>

    <!-- JS: Toggle, Payment -->
    <script>
        // Toggle passenger form on Apply Now click
        document.querySelectorAll('.select-btn').forEach(button => {
            button.addEventListener('click', () => {
                const cabCard = button.closest('.cab-card');
                const passengerBox = cabCard.querySelector('.passenger-box');
                if (passengerBox.style.display === 'none' || passengerBox.style.display === '') {
                    passengerBox.style.display = 'block';
                    button.innerText = 'APPLY NOW';
                } else {
                    passengerBox.style.display = 'none';
                    button.innerText = 'APPLY NOW';
                }
            });
        });

        // Proceed to Payment
        function proceedToPayment(btn) {
            const paymentBox = btn.nextElementSibling;
            if (paymentBox) {
                paymentBox.style.display = 'block';
                btn.style.display = 'none';
            }
        }

        // Complete Payment
        function completePayment(btn) {
            const inputs = btn.parentElement.querySelectorAll("input");
            let valid = true;
            inputs.forEach(input => {
                if (input.value.trim() === '') valid = false;
            });

            if (!valid) {
                alert("❌ Please fill all payment details.");
            } else {
                alert("✅ Payment successful!\n🎉 Your cab has been booked!");
            }
        }
    </script>
</body>

</html>