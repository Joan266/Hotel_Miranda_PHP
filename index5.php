<?php

$servername = "localhost";
$username = "joanale"; 
$password = "1q2w3e4r";   
$dbname = "hotel_miranda"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, room_type, bed_type, floor_room, facilities, rate, status FROM rooms";
$result = $conn->query($sql);

$rooms = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['facilities'] = explode(',', $row['facilities']);
        $rooms[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms List</title>
</head>
<body>

<h2>Rooms List</h2>

<ol>
    <?php foreach ($rooms as $room): ?>
        <li>
            <strong>ID:</strong> <?php echo htmlspecialchars($room['id']); ?><br>
            <strong>Room Type:</strong> <?php echo htmlspecialchars($room['room_type']); ?><br>
            <strong>Bed Type:</strong> <?php echo htmlspecialchars($room['bed_type']); ?><br>
            <strong>Floor Room:</strong> <?php echo htmlspecialchars($room['floor_room']); ?><br>
            <strong>Facilities:</strong> <?php echo implode(', ', array_map('htmlspecialchars', $room['facilities'])); ?><br>
            <strong>Rate:</strong> $<?php echo htmlspecialchars($room['rate']); ?><br>
            <strong>Status:</strong> <?php echo htmlspecialchars($room['status']); ?>
        </li>
    <?php endforeach; ?>
</ol>

</body>
</html>
