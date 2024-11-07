<?php
session_start();
$title = "Pet Gallery";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');


$stmt = $conn->prepare("SELECT id, petname, image, caption FROM pets ORDER BY id DESC");
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Pet Gallery</h2>
<div class="gallery-container">
    <?php foreach ($pets as $pet): ?>
        <div class="gallery-item">
            <a href="details.php?id=<?php echo htmlspecialchars($pet['id']); ?>">
                <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['petname']); ?>" class="gallery-image">
            </a>
            <div class="gallery-caption">
                <strong><?php echo htmlspecialchars($pet['petname']); ?></strong>
                <p><?php echo htmlspecialchars($pet['caption']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include('includes/footer.inc.php'); ?>
