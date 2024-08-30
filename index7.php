<?php

$servername = "localhost";
$username = "joanale"; 
$password = "1q2w3e4r";   
$dbname = "hotel_miranda"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $stmt = $conn->prepare("SELECT id, room_type, bed_type, floor_room, facilities, rate, status FROM rooms WHERE room_type LIKE ?");
    $likeSearch = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $likeSearch);
} else {
    $stmt = $conn->prepare("SELECT id, room_type, bed_type, floor_room, facilities, rate, status FROM rooms");
}

$stmt->execute();
$result = $stmt->get_result();
$rooms = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms List with Search</title>
</head>
<body>

<h2>Rooms List with Search</h2>

<form>
    <input type="text" name="search" placeholder="Search room type..." value="<?php echo htmlspecialchars($searchQuery); ?>">
    <button type="submit">Search</button>
</form>

<ol>
    <?php if (!empty($rooms)): ?>
        <?php foreach ($rooms as $room): ?>
            <li>
                <strong>ID:</strong> <?php echo htmlspecialchars($room['id']); ?><br>
                <strong>Room Type:</strong> <?php echo htmlspecialchars($room['room_type']); ?><br>
                <strong>Bed Type:</strong> <?php echo htmlspecialchars($room['bed_type']); ?><br>
                <strong>Floor Room:</strong> <?php echo htmlspecialchars($room['floor_room']); ?><br>
                <strong>Facilities:</strong> <?php echo implode(', ', array_map('htmlspecialchars', explode(',', $room['facilities']))); ?><br>
                <strong>Rate:</strong> $<?php echo htmlspecialchars($room['rate']); ?><br>
                <strong>Status:</strong> <?php echo htmlspecialchars($room['status']); ?>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No rooms found.</li>
    <?php endif; ?>
</ol>

</body>
</html>
