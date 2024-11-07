<?php
$title = "Pet Details Page";
include('includes/db_connect.inc');
include('includes/header.inc'); 
include('includes/nav.inc'); 

if (!isset($_GET['id'])) {
    header("Location: gallery.php"); 
    exit();
}

$petId = intval($_GET['id']);

$query = "SELECT * FROM pets WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $petId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pet = $result->fetch_assoc();
} else {
    echo "<p class='text-center'>No pet found.</p>";
    exit();
}
?>

<main class="container my-4 flex-grow-1">
    <h1 class="text-center mb-4"><?= htmlspecialchars($pet['name']) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h3>Details</h3>
            <p><strong><i class="fas fa-paw"></i> Type:</strong> <?= htmlspecialchars($pet['type']) ?></p>
            <p><strong><i class="fas fa-calendar-alt"></i> Age:</strong> <?= htmlspecialchars($pet['age']) ?> months</p>
            <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> <?= htmlspecialchars($pet['location']) ?></p>
            <p><strong><i class="fas fa-info-circle"></i> Description:</strong> <?= htmlspecialchars($pet['description']) ?></p>
            <a href="gallery.php" class="btn btn-secondary">Back to Gallery</a>
        </div>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
