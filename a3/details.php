<?php
session_start();
$title = "Pet Details";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');

if (isset($_GET['petid'])) {
    $petid = $_GET['petid'];

    
    $stmt = $conn->prepare("SELECT petname, type, description, image, caption, age, location FROM pets WHERE petid = :petid");
    $stmt->bindParam(':petid', $petid);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if (!$pet) {
        echo "<p>Pet not found.</p>";
    }
} else {
    echo "<p>No pet selected.</p>";
    include('includes/footer.inc.php');
    exit();
}
?>

<?php if ($pet): ?>
    <h2><?php echo htmlspecialchars($pet['petname']); ?></h2>
    <div class="pet-details">
        <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['petname']); ?>" class="img-fluid">
        <p><strong>Type:</strong> <?php echo htmlspecialchars($pet['type']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($pet['description']); ?></p>
        <p><strong>Image Caption:</strong> <?php echo htmlspecialchars($pet['caption']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> years</p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($pet['location']); ?></p>
    </div>
<?php endif; ?>

<?php include('includes/footer.inc.php'); ?>
