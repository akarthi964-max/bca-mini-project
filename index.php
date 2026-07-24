<?php
require_once 'config.php';

$message = '';

// Handle HTTP POST request from booking form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hall_id        = $_POST['hall_id'] ?? '';
    $applicant_name = trim($_POST['applicant_name'] ?? '');
    $event_name     = trim($_POST['event_name'] ?? '');
    $booking_date   = $_POST['booking_date'] ?? '';
    $start_time     = $_POST['start_time'] ?? '';
    $end_time       = $_POST['end_time'] ?? '';

    if ($hall_id && $applicant_name && $event_name && $booking_date && $start_time && $end_time) {
        $stmt = $pdo->prepare("INSERT INTO bookings (hall_id, applicant_name, event_name, booking_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$hall_id, $applicant_name, $event_name, $booking_date, $start_time, $end_time])) {
            $message = "<div class='alert success'>Request submitted successfully! Waiting for Admin approval.</div>";
        } else {
            $message = "<div class='alert error'>Failed to submit request. Try again.</div>";
        }
    } else {
        $message = "<div class='alert error'>Please fill in all fields.</div>";
    }
}

// Fetch halls for dropdown
$halls = $pdo->query("SELECT * FROM halls")->fetchAll();

// Fetch scheduled bookings
$query = "SELECT b.*, h.hall_name 
          FROM bookings b 
          JOIN halls h ON b.hall_id = h.id 
          ORDER BY b.booking_date DESC, b.start_time ASC";
$bookings = $pdo->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCU Campus Hall Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>BCU Hall & Event Booking System</h1>
    <a href="admin.php" class="admin-link">Admin Portal</a>
</header>

<div class="container">
    <?= $message ?>

    <!-- Booking Form Section -->
    <section class="card">
        <h2>Request a Venue</h2>
        <form action="index.php" method="POST" id="bookingForm">
            <div class="form-group">
                <label for="applicant_name">Your Name / Department:</label>
                <input type="text" id="applicant_name" name="applicant_name" required placeholder="e.g. Rahul - BCA 5th Sem">
            </div>

            <div class="form-group">
                <label for="event_name">Event Title:</label>
                <input type="text" id="event_name" name="event_name" required placeholder="e.g. Mini Project Presentation">
            </div>

            <div class="form-group">
                <label for="hall_id">Select Hall:</label>
                <select id="hall_id" name="hall_id" required>
                    <option value="">-- Choose Venue --</option>
                    <?php foreach ($halls as $hall): ?>
                        <option value="<?= $hall['id'] ?>"><?= htmlspecialchars($hall['hall_name']) ?> (Cap: <?= $hall['capacity'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="booking_date">Date:</label>
                    <input type="date" id="booking_date" name="booking_date" required>
                </div>
                <div class="form-group">
                    <label for="start_time">Start Time:</label>
                    <input type="time" id="start_time" name="start_time" required>
                </div>
                <div class="form-group">
                    <label for="end_time">End Time:</label>
                    <input type="time" id="end_time" name="end_time" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Booking Request</button>
        </form>
    </section>

    <!-- Schedule Table -->
    <section class="card">
        <h2>Current Venue Schedule</h2>
        <table>
            <thead>
                <tr>
                    <th>Venue</th>
                    <th>Event</th>
                    <th>Applicant</th>
                    <th>Date</th>
                    <th>Timing</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($bookings) > 0): ?>
                    <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($b['hall_name']) ?></strong></td>
                            <td><?= htmlspecialchars($b['event_name']) ?></td>
                            <td><?= htmlspecialchars($b['applicant_name']) ?></td>
                            <td><?= $b['booking_date'] ?></td>
                            <td><?= date('h:i A', strtotime($b['start_time'])) ?> - <?= date('h:i A', strtotime($b['end_time'])) ?></td>
                            <td><span class="badge status-<?= strtolower($b['status']) ?>"><?= $b['status'] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">No booking records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>

<script src="script.js"></script>
</body>
</html>