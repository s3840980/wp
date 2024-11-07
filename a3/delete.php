<?php
session_start(); 
$title = "Delete Pet Page";
include('include/db_connect.inc'); 
include('include/header.inc'); 
include('include/nav.inc'); 

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $petId = intval($_GET['id']); 

    $query = "SELECT image_path FROM pets WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $petId, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<div class='alert alert-danger'>No pet found with that ID.</div>";
        exit();
    }

    $pet = $result->fetch_assoc();
    $stmt->close();

    $deleteQuery = "DELETE FROM pets WHERE id = ? AND user_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $petId, $_SESSION['id']);

    if ($deleteStmt->execute()) {
        // Delete the image file from the server
        if (file_exists($pet['image_path'])) {
            unlink($pet['image_path']); // Delete the file
        }
        echo "<div class='alert alert-success'>Pet deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting pet. Please try again.</div>";
    }

    $deleteStmt->close();
} else {
    echo "<div class='alert alert-danger'>No pet ID provided.</div>";
    exit();
}
?>

<main class="container my-4">
    <h1 class="text-center mb-4">Delete Pet</h1>
    <p class="text-center mb-4">The pet has been deleted. You can go back to your pet list.</p>
    <div class="text-center">
        <a href="user.php" class="btn btn-primary">Go to Pet List</a>
    </div>
</main>

<?php include('include/footer.inc'); ?>
