<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$title = "User Profile";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');

$username = $_SESSION['username'];


$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = :id");
$stmt->bindParam(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$pets_stmt = $conn->prepare("SELECT id, petname, image, caption FROM pets WHERE username = :username ORDER BY id DESC");
$pets_stmt->bindParam(':username', $username);
$pets_stmt->execute();
$pets = $pets_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>User Profile</h2>

<div class="user-profile">
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
</div>

<h3>Your Pets</h3>
<div class="gallery-container">
    <?php if (count($pets) > 0): ?>
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
    <?php else: ?>
        <p>You have not added any pets yet.</p>
    <?php endif; ?>
</div>

<?php include('includes/footer.inc.php'); ?>
