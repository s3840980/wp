<?php
session_start();
$title = "User Pets Page";
include('includes/db_connect.inc');
include('includes/header.inc');
include('includes/nav.inc');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Prepare SQL statement to fetch user’s pets based on username
$query = "SELECT petid, petname, type, description, age, location, image, caption FROM pets WHERE username = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("SQL preparation failed: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container my-4">
    <h1 class="m-4 text-center"><?= htmlspecialchars($_SESSION['username']) ?>'s Pet Collection</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($pet = $result->fetch_assoc()): ?>
            <div class="row mb-5">
                <div class="col-md-4">
                    <img src="<?= htmlspecialchars($pet['image']) ?>" alt="<?= htmlspecialchars($pet['petname']) ?>" class="pet-image mb-3">
                </div>
                <div class="col-md-8">
                    <h2><?= htmlspecialchars($pet['petname']) ?></h2>
                    <p><?= htmlspecialchars($pet['description']) ?></p>
                    <div class="pet-info">
                        <span><i class="far fa-clock"></i> <?= htmlspecialchars($pet['age']) ?> months</span>
                        <span><i class="fas fa-paw"></i> <?= htmlspecialchars($pet['type']) ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($pet['location']) ?></span>
                    </div>
                    <a href="edit.php?petid=<?= $pet['petid'] ?>" class="btn btn-primary">Edit</a>
                    <a href="delete.php?petid=<?= $pet['petid'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <h3>You have no pets listed.</h3>
            <p class="mb-4">Click the button below to add your first pet!</p>
            <a href="add.php" class="btn btn-success">Add Pet</a>
        </div>
    <?php endif; ?>

    <?php
    $result->free();
    $stmt->close();
    ?>
</main>

<?php include('includes/footer.inc'); ?>
