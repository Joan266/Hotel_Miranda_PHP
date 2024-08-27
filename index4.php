<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

$jsonData = file_get_contents('rooms.json');
$rooms = json_decode($jsonData, true);

$foundRoom = null;

foreach ($rooms as $room) {
    if ($room['id'] === $id) {
        $foundRoom = $room;
        break;
    }
}
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

<?php if ($foundRoom): ?>
    <p><strong>ID:</strong> <?php echo htmlspecialchars($foundRoom['id']); ?></p>
    <p><strong>Room Type:</strong> <?php echo htmlspecialchars($foundRoom['room_type']); ?></p>
    <p><strong>Bed Type:</strong> <?php echo htmlspecialchars($foundRoom['bed_type']); ?></p>
    <p><strong>Floor Room:</strong> <?php echo htmlspecialchars($foundRoom['floor_room']); ?></p>
    <p><strong>Facilities:</strong> <?php echo implode(', ', array_map('htmlspecialchars', $foundRoom['facilities'])); ?></p>
    <p><strong>Rate:</strong> $<?php echo htmlspecialchars($foundRoom['rate']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($foundRoom['status']); ?></p>
<?php else: ?>
    <p>No room found with ID <?php echo htmlspecialchars($id); ?>.</p>
<?php endif; ?>

</body>
</html>
