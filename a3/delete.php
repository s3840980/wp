<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/db_connect.inc.php');

$pet_id = $_GET['id'];
$message = "";


$stmt = $conn->prepare("SELECT * FROM pets WHERE id = :id AND username = :username");
$stmt->bindParam(':id', $pet_id);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    echo "Pet not found or you do not have permission to delete this pet.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $conn->prepare("DELETE FROM pets WHERE id = :id AND username = :username");
        $stmt->bindParam(':id', $pet_id);
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();

        header("Location: pets.php");
        exit();
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<h2>Delete Pet</h2>
<p>Are you sure you want to delete the pet: <?php echo htmlspecialchars($pet['petname']); ?>?</p>
<form method="POST" action="">
    <button type="submit" class="btn-custom">Yes, Delete</button>
    <a href="pets.php" class="btn-custom">Cancel</a>
</form>

<?php include('includes/footer.inc.php'); ?>
