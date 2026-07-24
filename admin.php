<?php
require_once 'config.php';

// Handle Action (Approve / Reject)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'] === 'approve' ? 'Approved' : ($_GET['action'] === 'reject' ? 'Rejected' : '');

    if ($action) {
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$action, $id]);
        header("Location: admin.php");
        exit;
    }
}

// Fetch all bookings
$query = "SELECT b.*, h.hall_name 
          FROM bookings b 
          JOIN halls h ON b.hall_id = h.id 
          ORDER BY b.created_at DESC";
$bookings = $pdo->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BCU Hall Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Admin Approval Dashboard</h1>
    <a href="index.php" class="admin-link">Back to Main Portal</a>
</header>

<div class="container">
    <section class="card">
        <h2>Manage Pending Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Requested Venue</th>
                    <th>Event Title</th>
                    <th>Applicant</th>
                    <th>Date & Time</th>
                    <th>Current Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($b['hall_name']) ?></strong></td>
                        <td><?= htmlspecialchars($b['event_name']) ?></td>
                        <td><?= htmlspecialchars($b['applicant_name']) ?></td>
                        <td>
                            <?= $b['booking_date'] ?><br>
                            <small><?= date('h:i A', strtotime($b['start_time'])) ?> - <?= date('h:i A', strtotime($b['end_time'])) ?></small>
                        </td>
                        <td><span class="badge status-<?= strtolower($b['status']) ?>"><?= $b['status'] ?></span></td>
                        <td>
                            <?php if ($b['status'] === 'Pending'): ?>
                                <a href="admin.php?action=approve&id=<?= $b['id'] ?>" class="btn-action approve">Approve</a>
                                <a href="admin.php?action=reject&id=<?= $b['id'] ?>" class="btn-action reject">Reject</a>
                            <?php else: ?>
                                <small>Processed</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>