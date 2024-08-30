<?php

$servername = "localhost";
$username = "joanale"; 
$password = "1q2w3e4r";   
$dbname = "hotel_miranda"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $room_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT id, room_type, bed_type, floor_room, facilities, rate, status FROM rooms WHERE id = ?");
    $stmt->bind_param("s", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
        $room['facilities'] = explode(',', $room['facilities']); 
    } else {
        echo "No room found with ID " . htmlspecialchars($room_id);
        $room = null;
    }
    $stmt->close();
} else {
    echo "No ID specified in the query.";
    $room = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
</head>
<body>

<h2>Room Details</h2>

<?php if ($room): ?>
    <ul>
        <li><strong>ID:</strong> <?php echo htmlspecialchars($room['id']); ?></li>
        <li><strong>Room Type:</strong> <?php echo htmlspecialchars($room['room_type']); ?></li>
        <li><strong>Bed Type:</strong> <?php echo htmlspecialchars($room['bed_type']); ?></li>
        <li><strong>Floor Room:</strong> <?php echo htmlspecialchars($room['floor_room']); ?></li>
        <li><strong>Facilities:</strong> <?php echo implode(', ', array_map('htmlspecialchars', $room['facilities'])); ?></li>
        <li><strong>Rate:</strong> $<?php echo htmlspecialchars($room['rate']); ?></li>
        <li><strong>Status:</strong> <?php echo htmlspecialchars($room['status']); ?></li>
    </ul>
<?php else: ?>
    <p>No room data to display.</p>
<?php endif; ?>

</body>
</html>
