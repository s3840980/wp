<?php
$title = "Search Results";
include('includes/db_connect.inc');
include('includes/header.inc'); 
include('includes/nav.inc');

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$petType = isset($_GET['pet_type']) ? $_GET['pet_type'] : '';

$query = "SELECT name, image_path, id FROM pets WHERE 1=1";

if ($keyword) {
    $query .= " AND (name LIKE ? OR location LIKE ? OR description LIKE ?)";
}
if ($petType) {
    $query .= " AND type = ?";
}

$stmt = $conn->prepare($query);

$types = '';
$params = [];
if ($keyword) {
    $types .= 'sss'; 
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%"; 
}
if ($petType) {
    $types .= 's';
    $params[] = $petType; 
}

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container my-4">
    <h1 class="text-center mb-4">Search Results</h1>

    <div class="row g-4">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($pet = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="pet-card">
                        <a href="details.php?id=<?= $pet['id'] ?>" style="text-decoration: none;">
                            <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="img-fluid">
                            <div class="pet-name"><?= htmlspecialchars($pet['name']) ?></div>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-md-12">
                <p class="text-center">No pets found matching your search criteria.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
