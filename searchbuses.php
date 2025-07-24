<?php
function getAvailableBuses() {
    return [
        ["Chennai", "Coimbatore", "10:00 AM", "04:00 PM", "850"],
        ["Bangalore", "Hyderabad", "09:30 AM", "03:00 PM", "750"]
    ];
}
$buses = getAvailableBuses();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Search Buses</title>
</head>

<body>
    <h2>Available Buses</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Fare (₹)</th>
        </tr>
        <?php foreach ($buses as $bus): ?>
        <tr>
            <td>
                <?= $bus[0] ?>
            </td>
            <td>
                <?= $bus[1] ?>
            </td>
            <td>
                <?= $bus[2] ?>
            </td>
            <td>
                <?= $bus[3] ?>
            </td>
            <td>
                <?= $bus[4] ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="index.php">← Back to Home</a></p>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Buses - RedBus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .sidebar {
            width: 250px;
            background: #fff;
            padding: 15px;
            border: 1px solid #ccc;
        }

        .main {
            flex: 1;
        }

        .bus-card {
            border: 1px solid #ccc;
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
        }

        .bus-card h3 {
            margin: 0 0 5px;
        }

        .rating-box {
            background: #4caf50;
            color: white;
            display: inline-block;
            padding: 2px 8px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .section {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            background: #fdfdfd;
        }

        .square-seat,
        .sleeper-seat {
            position: relative;
            border: 2px solid #999;
            border-radius: 10px;
            background-color: white;
        }

        .square-seat {
            width: 35px;
            height: 35px;
        }

        .sleeper-seat {
            width: 40px;
            height: 100px;
        }

        .sleeper-seat.selected,
        .square-seat.selected {
            background-color: #4caf50;
            border-color: #388e3c;
        }

        .sleeper-seat::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 6px;
            width: 28px;
            height: 12px;
            background-color: #e5f3e2;
            border-radius: 6px;
        }

        .price-tag {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-top: 4px;
        }

        .berth-column {
            border: 2px solid #ccc;
            border-radius: 16px;
            padding: 20px;
            background: #fff;
            margin: 10px 0;
        }

        .berth-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .seat-grid {
            display: grid;
            grid-template-columns: repeat(3, auto);
            gap: 20px 30px;
        }

        .empty-space {
            width: 50px;
        }

        .payment-box {
            display: none;
            margin-top: 15px;
            border: 1px solid #aaa;
            padding: 15px;
            background: #fff;
        }

        .strike {
            text-decoration: line-through;
            color: grey;
        }

        .ticket-box {
            display: none;
            margin-top: 15px;
            padding: 15px;
            border: 1px solid #aaa;
            background: #e8ffe8;
        }

        .main-container {
            display: flex;
            justify-content: center;
            gap: 50px;
        }

        .berth-column {
            border: 2px solid #ccc;
            border-radius: 16px;
            padding: 20px;
            background: #fff;
        }

        .berth-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .seat-grid {
            display: grid;
            grid-template-columns: repeat(3, auto);
            gap: 20px 30px;
        }

        .empty-space {
            width: 50px;
        }

        .sleeper-seat,
        .square-seat {
            position: relative;
            border: 2px solid #999;
            border-radius: 10px;
            background-color: white;
        }

        .sleeper-seat {
            width: 40px;
            height: 100px;
        }

        .sleeper-seat.selected,
        .square-seat.selected {
            background-color: #4caf50;
            border-color: #388e3c;
        }

        .sleeper-seat::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 6px;
            width: 28px;
            height: 12px;
            background-color: #e5f3e2;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div><strong>Filters</strong></div>
            <div><input type="checkbox"> AC</div>
            <div><input type="checkbox"> Non-AC</div>
            <div style="margin-top:15px"><strong>Seat type</strong></div>
            <div><input type="checkbox"> Sleeper</div>
            <div><input type="checkbox"> Seater</div>
            <div style="margin-top:15px"><strong>Pick up point - Delhi</strong></div>
            <div><input type="checkbox"> Anand Vihar (65)</div>
            <div><input type="checkbox"> ISBT Kashmiri Gate (50)</div>
            <div><input type="checkbox"> Kaushambi (20)</div>
            <div style="margin-top:15px"><strong>Pick up time</strong></div>
            <div><input type="checkbox"> 6 AM to 11 AM</div>
            <div><input type="checkbox"> 11 AM to 6 PM</div>
            <div><input type="checkbox"> 6 PM to 11 PM</div>
        </div>
        <div class="main" id="bus-list"></div>
    </div>

    <script>
        const buses = [
            { id: 1, name: "Laxmi Holidays", rating: 4.7, from: "20:00", to: "03:15", duration: "7h 15m", seats: 46, windows: 26, price: 810 },
            { id: 2, name: "Laxmi Holidays", rating: 4.6, from: "23:20", to: "07:30", duration: "8h 10m", seats: 46, windows: 26, price: 825 },
            { id: 3, name: "Zingbus Plus", rating: 4.6, from: "23:10", to: "07:55", duration: "8h 45m", seats: 32, windows: 21, price: 722, oldPrice: 825 }
        ];

        function init() {
            const busList = document.getElementById("bus-list");
            busList.innerHTML = buses.map(bus => `
                <div class="bus-card">
                    <h3>${bus.name}</h3>
                    <div class="rating-box">★ ${bus.rating}</div>
                    <p>${bus.from} → ${bus.to} (${bus.duration})</p>
                    <p>${bus.seats} Seats Left - ${bus.windows} Window Seats</p>
                    <p>${bus.oldPrice ? `<span class="strike">₹${bus.oldPrice}</span> ₹${bus.price}` : `₹${bus.price}`}</p>
                    <button onclick="toggleSeatLayout(this)">SELECT SEATS</button>
                    <div class="section seat-layout" style="display:none">
                    <div class="main-container">
                        <div class="berth-column">
                            <div class="berth-title">LOWER BERTH (29)</div>
                            <div class="seat-grid">
                                <div class="empty-space"></div>
                                    <div>
                                        <div class="square-seat" data-price="953"></div>
                                        <div class="price-tag">₹953</div>
                                        <div class="square-seat" data-price="953"></div>
                                        <div class="price-tag">₹953</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1663"></div>
                                        <div class="price-tag">₹1663</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="953"></div>
                                        <div class="price-tag">₹953</div>
                                        <div class="square-seat" data-price="953"></div>
                                        <div class="price-tag">₹953</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1663"></div>
                                        <div class="price-tag">₹1663</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="810"></div>
                                        <div class="price-tag">₹810</div>
                                        <div class="square-seat" data-price="810"></div>
                                        <div class="price-tag">₹810</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1663"></div>
                                        <div class="price-tag">₹1663</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="810"></div>
                                        <div class="price-tag">₹810</div>
                                        <div class="square-seat" data-price="810"></div>
                                        <div class="price-tag">₹810</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1663"></div>
                                        <div class="price-tag">₹1663</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="810"></div>
                                        <div class="price-tag">₹810</div>
                                        <div class="square-seat" data-price="810"></div>
                                        <div class="price-tag">₹810</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1663"></div>
                                        <div class="price-tag">₹1663</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="810"></div>
                                        <div class="price-tag">₹810</div>
                                        <div class="square-seat" data-price="810"></div>
                                        <div class="price-tag">₹810</div>
                                    </div>
                                    <div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                        <div class="square-seat" data-price="1048"></div>
                                        <div class="price-tag">₹1048</div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="berth-column">
                                <div class="berth-title">UPPER BERTH (17)</div>
                                <div class="seat-grid">
                                    <div class="empty-space"></div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1607"></div>
                                        <div class="price-tag">₹1607</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1607"></div>
                                        <div class="price-tag">₹1607</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1607"></div>
                                        <div class="price-tag">₹1607</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1607"></div>
                                        <div class="price-tag">₹1607</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1377"></div>
                                        <div class="price-tag">₹1377</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1607"></div>
                                        <div class="price-tag">₹1607</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1262"></div>
                                        <div class="price-tag">₹1262</div>
                                    </div>
                                    <div>
                                        <div class="sleeper-seat" data-price="1262"></div>
                                        <div class="price-tag">₹1262</div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        
                        <p class="seat-summary">Selected: None</p>
                        <p class="total-summary">Total: ₹0</p>
                        <button onclick="proceedToPayment(this)">Proceed to Payment</button>
                        <div class="payment-box">
                            <h3>Payment</h3>
                            <input type="text" placeholder="Card Number"><br>
                            <input type="text" placeholder="Name on Card"><br>
                            <input type="text" placeholder="Expiry"><br>
                            <input type="text" placeholder="CVV"><br>
                            <button onclick="completePayment(this)">Pay Now</button>
                        </div>
                        <div class="ticket-box">
                            <h3>🎫 Ticket Confirmed!</h3>
                            <p><strong>Bus:</strong> ${bus.name}</p>
                            <p><strong>Seats:</strong> <span class="final-seats"></span></p>
                            <p><strong>Total:</strong> <span class="final-price"></span></p>
                        </div>
                    </div>
                </div>
            `).join('');
            setupSeatEvents();
        }

        function toggleSeatLayout(button) {
            const layout = button.nextElementSibling;
            layout.style.display = layout.style.display === 'none' ? 'block' : 'none';
        }

        function setupSeatEvents() {
            document.querySelectorAll('.square-seat, .sleeper-seat').forEach(seat => {
                seat.addEventListener('click', () => {
                    seat.classList.toggle('selected');
                    updateSummary();
                });
            });
        }

        function updateSummary() {
            document.querySelectorAll('.seat-layout').forEach(layout => {
                const selected = layout.querySelectorAll('.selected');
                let total = 0;
                let seatList = [];
                selected.forEach(seat => {
                    const price = parseInt(seat.getAttribute('data-price'));
                    total += price;
                    seatList.push(`₹${price}`);
                });
                layout.querySelector('.seat-summary').textContent = 'Selected: ' + (seatList.join(', ') || 'None');
                layout.querySelector('.total-summary').textContent = 'Total: ₹' + total;
            });
        }

        function proceedToPayment(btn) {
            const layout = btn.closest('.seat-layout');
            layout.querySelector('.payment-box').style.display = 'block';
        }

        function completePayment(btn) {
            const layout = btn.closest('.seat-layout');
            const ticketBox = layout.querySelector('.ticket-box');
            const finalSeats = layout.querySelector('.final-seats');
            const finalPrice = layout.querySelector('.final-price');
            const selected = layout.querySelectorAll('.selected');
            let total = 0;
            let seats = [];

            selected.forEach(seat => {
                const price = parseInt(seat.getAttribute('data-price'));
                total += price;
                seats.push(`₹${price}`);
            });

            finalSeats.textContent = seats.join(', ');
            finalPrice.textContent = '₹' + total;
            ticketBox.style.display = 'block';

            // Save to localStorage
            localStorage.setItem("from", "Delhi"); // You can set dynamically later
            localStorage.setItem("to", "Manali");
            localStorage.setItem("date", new Date().toLocaleDateString());
            localStorage.setItem("selectedSeats", seats.join(', '));
            localStorage.setItem("totalFare", total);
            localStorage.setItem("selectedBusId", "1");
            alert('Payment Successful! Ticket Confirmed.');

        }

        window.onload = init;
    </script>
</body>

</html>