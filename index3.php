<?php
$rooms = json_decode(file_get_contents('rooms.json'), true);
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