<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Receipt</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            flex: 1;
            margin: 20px 0;
        }
        .content p {
            margin: 8px 0;
        }
        .content strong {
            font-weight: bold;
        }
        .total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
        }
        .deposit-note {
            margin-top: 20px;
            font-style: italic;
            color: #d9534f;
            font-size: 12px;
        }
        .footer {
            font-size: 10px;
            text-align: center;
            color: #777;
            margin-top: 40px;
            padding: 20px;
        }
        .amenities ul {
            margin-top: 10px;
            padding-left: 20px;
        }
        .amenities li {
            list-style-type: disc;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reservation Receipt</h1>
    </div>

    <div class="content">
        <p><strong>Name:</strong> {{ $reservation->name }}</p>
        <p><strong>Email:</strong> {{ $reservation->email }}</p>
        <p><strong>Venue Name:</strong> {{ $reservation->VenueName }}</p>

        <p>{{ $reservation->VenueName }} is a refined blend of luxury and comfort, designed to provide guests with an unforgettable stay. This elegantly furnished room features a king-sized bed with premium linens, a marble-accented bathroom with a rain shower, and a cozy seating area perfect for unwinding after a long day. With floor-to-ceiling windows offering stunning views of the city skyline, the suite creates an atmosphere of serenity and sophistication.</p>

        <p>Your reservation includes not only the exceptional comforts of {{ $reservation->VenueName }}, but also a range of premium amenities designed to enhance your experience. Guests can enjoy a selection of complimentary services such as:</p>

        <div class="amenities">
            <ul>
                <li>Free Wi-Fi</li>
                <li>Free Parking</li>
                <li>Swimming Pool</li>
                <li>Gym</li>
                <li>Free Breakfast</li>
                <li>Room Service</li>
                <li>Smart TV with Cable Channels</li>
                <li>Air Conditioning</li>
                <li>Hair Dryer</li>
                <li>Coffee/Tea Maker</li>
                <li>Electric Kettle</li>
            </ul>
        </div>

        <p><strong>Check-In Date:</strong> {{ $reservation->check_in }}</p>
        <p><strong>Check-Out Date:</strong> {{ $reservation->check_out }}</p>
        <p><strong>Number of Days:</strong> {{ $reservation->number_of_days }}</p>

        <p><strong>Original Amount:</strong> {{ number_format($reservation->amount, 2) }}</p>
        <p><strong>Discount ({{ $reservation->discount }}%):</strong> {{ number_format(($reservation->amount * $reservation->discount / 100), 2) }}</p>
        <p><strong>Final Amount Due:</strong> {{ number_format($reservation->amount - ($reservation->amount * $reservation->discount / 100), 2) }}</p>

        <div class="total">
            <p><strong>Total Paid: {{ number_format($reservation->amount - ($reservation->amount * $reservation->discount / 100), 2) }}</strong></p>
        </div>

        <div class="deposit-note">
            <p><strong>Important:</strong> The total amount of {{ number_format($reservation->amount - ($reservation->amount * $reservation->discount / 100), 2) }} has already been paid to confirm your reservation. No further payment is required.</p>
        </div>

        <p><strong>Payment Method:</strong> {{ $reservation->payment_method }}</p>
        <p><strong>Payment Code:</strong> {{ $reservation->payment_code }}</p>
        <p><strong>Voucher Code:</strong> {{ $reservation->vouchers_code }}</p>
    </div>

    <div class="footer">
        <p>Thank you for choosing our services. We look forward to your stay!</p>
    </div>

</body>
</html>
