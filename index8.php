<?php

$servername = "localhost";
$username = "joanale"; 
$password = "1q2w3e4r";   
$dbname = "hotel_miranda"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$newRoom = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $room_type = $_POST['room_type'];
    $bed_type = $_POST['bed_type'];
    $floor_room = $_POST['floor_room'];
    $facilities = $_POST['facilities']; 
    $rate = $_POST['rate'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO rooms (id, room_type, bed_type, floor_room, facilities, rate, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $id, $room_type, $bed_type, $floor_room, $facilities, $rate, $status);

    if ($stmt->execute()) {
        $newRoom = [
            'id' => $id,
            'room_type' => $room_type,
            'bed_type' => $bed_type,
            'floor_room' => $floor_room,
            'facilities' => explode(',', $facilities), // Convertir string a array
            'rate' => $rate,
            'status' => $status,
        ];
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Room</title>
</head>
<body>

<h2>Create New Room</h2>

<form method="POST">
    <label for="id">ID:</label><br>
    <input type="text" id="id" name="id" required><br><br>
    
    <label for="room_type">Room Type:</label><br>
    <input type="text" id="room_type" name="room_type" required><br><br>
    
    <label for="bed_type">Bed Type:</label><br>
    <input type="text" id="bed_type" name="bed_type" required><br><br>
    
    <label for="floor_room">Floor Room:</label><br>
    <input type="text" id="floor_room" name="floor_room" required><br><br>
    
    <label for="facilities">Facilities (separated by commas):</label><br>
    <input type="text" id="facilities" name="facilities" required><br><br>
    
    <label for="rate">Rate:</label><br>
    <input type="number" id="rate" name="rate" required><br><br>
    
    <label for="status">Status:</label><br>
    <input type="text" id="status" name="status" required><br><br>
    
    <button type="submit">Create Room</button>
</form>

<?php if ($newRoom): ?>
    <h2>New Room Details</h2>
    <ul>
        <li><strong>ID:</strong> <?php echo htmlspecialchars($newRoom['id']); ?></li>
        <li><strong>Room Type:</strong> <?php echo htmlspecialchars($newRoom['room_type']); ?></li>
        <li><strong>Bed Type:</strong> <?php echo htmlspecialchars($newRoom['bed_type']); ?></li>
        <li><strong>Floor Room:</strong> <?php echo htmlspecialchars($newRoom['floor_room']); ?></li>
        <li><strong>Facilities:</strong> <?php echo implode(', ', array_map('htmlspecialchars', $newRoom['facilities'])); ?></li>
        <li><strong>Rate:</strong> $<?php echo htmlspecialchars($newRoom['rate']); ?></li>
        <li><strong>Status:</strong> <?php echo htmlspecialchars($newRoom['status']); ?></li>
    </ul>
<?php endif; ?>

</body>
</html>
