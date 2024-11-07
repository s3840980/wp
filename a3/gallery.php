<?php
$title = "Gallery Page";
include('includes/db_connect.inc');
include('includes/header.inc'); 
include('includes/nav.inc'); 

$petType = isset($_GET['pet_type']) ? $_GET['pet_type'] : '';

$query = "SELECT petname, image, petid FROM pets WHERE 1=1"; 

if ($petType) {
    $query .= " AND type = ?";
}

$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("SQL preparation failed: " . htmlspecialchars($conn->error));
}

if ($petType) {
    $stmt->bind_param("s", $petType);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container my-4">
    <h1 class="text-center mb-4">Pet Gallery</h1>
    <div class="row g-4">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($pet = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="pet-card">
                        <a href="details.php?petid=<?= $pet['petid'] ?>" style="text-decoration: none;">
                            <img src="<?= htmlspecialchars($pet['image']) ?>" alt="<?= htmlspecialchars($pet['petname']) ?>" class="img-fluid">
                            <div class="pet-name"><?= htmlspecialchars($pet['petname']) ?></div>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-md-12">
                <p class="text-center">No pets found matching your criteria.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
