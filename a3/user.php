<?php
session_start(); 
$title = "User Pets Page";
include('includes/db_connect.inc'); 
include('includes/header.inc'); 
include('includes/nav.inc'); 


if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}


$userId = $_SESSION['id'];
$query = "SELECT id, name, type, description, age, location, image_path FROM pets WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container my-4">
    <h1 class="m-4 text-center"><?= htmlspecialchars($_SESSION['username']) ?>'s Collection</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($pet = $result->fetch_assoc()): ?>
            <div class="row mb-5">
                <div class="col-md-4">
                    <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="pet-image mb-3">
                </div>
                <div class="col-md-8">
                    <h2><?= htmlspecialchars($pet['name']) ?></h2>
                    <p><?= htmlspecialchars($pet['description']) ?></p>
                    <div class="pet-info">
                        <span><i class="far fa-clock"></i> <?= htmlspecialchars($pet['age']) ?> months</span>
                        <span><i class="fas fa-paw"></i> <?= htmlspecialchars($pet['type']) ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($pet['location']) ?></span>
                    </div>
                    <a href="edit.php?id=<?= $pet['id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="delete.php?id=<?= $pet['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
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
