<?php
$title = "Pet Details Page";
include('includes/db_connect.inc');
include('includes/header.inc'); 
include('includes/nav.inc'); 

// Check if 'id' parameter is provided
if (!isset($_GET['petid']) || !is_numeric($_GET['petid'])) {
    header("Location: gallery.php"); 
    exit();
}

$petId = intval($_GET['petid']); // Get the pet ID from URL

// Prepare and execute the SQL query to fetch pet details
$query = "SELECT * FROM pets WHERE petid = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    echo "SQL preparation failed: " . htmlspecialchars($conn->error);
    exit();
}
$stmt->bind_param("i", $petId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the pet details if found
if ($result && $result->num_rows > 0) {
    $pet = $result->fetch_assoc();
} else {
    echo "<p class='text-center'>No pet found.</p>";
    exit();
}
?>

<main class="container my-4 flex-grow-1">
    <h1 class="text-center mb-4"><?= htmlspecialchars($pet['petname']) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($pet['image']) ?>" alt="<?= htmlspecialchars($pet['petname']) ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h3>Details</h3>
            <p><strong>Type:</strong> <?= htmlspecialchars($pet['type']) ?></p>
            <p><strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?> months</p>
            <p><strong>Location:</strong> <?= htmlspecialchars($pet['location']) ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($pet['description']) ?></p>
            <a href="gallery.php" class="btn btn-secondary">Back to Gallery</a>
        </div>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
