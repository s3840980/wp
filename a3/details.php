<?php
session_start();
$title = "Pet Details";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');


if (!isset($_GET['id'])) {
    echo "Pet ID not specified.";
    exit();
}

$pet_id = $_GET['id'];


$stmt = $conn->prepare("SELECT petname, type, description, image, age, location, caption FROM pets WHERE id = :id");
$stmt->bindParam(':id', $pet_id);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    echo "Pet not found.";
    exit();
}
?>

<h2><?php echo htmlspecialchars($pet['petname']); ?></h2>

<div class="pet-details">
    <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['petname']); ?>" width="300">
    <p><strong>Type:</strong> <?php echo htmlspecialchars($pet['type']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($pet['description']); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($pet['location']); ?></p>
    <p><strong>Image Caption:</strong> <?php echo htmlspecialchars($pet['caption']); ?></p>
</div>

<a href="pets.php" class="btn btn-primary">Back to Pets</a>

<?php include('includes/footer.inc.php'); ?>
