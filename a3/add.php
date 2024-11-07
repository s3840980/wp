<?php
session_start();
$title = "Add Pets Page";
include('includes/db_connect.inc');
include('includes/header.inc');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$errorMsg = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petName = trim($_POST['petName']);
    $petType = $_POST['petType'];
    $petDescription = trim($_POST['petDescription']);
    $petAge = intval($_POST['petAge']);
    $petLocation = trim($_POST['petLocation']);
    $imageCaption = trim($_POST['imageCaption']);
    $userId = $_SESSION['id'];

    if (isset($_FILES['petImage']) && $_FILES['petImage']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['petImage']['type'];
        $fileName = basename($_FILES['petImage']['name']);
        $targetDirectory = "images/";
        $targetFile = $targetDirectory . uniqid() . "_" . $fileName;

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['petImage']['tmp_name'], $targetFile)) {
                
                // Prepare SQL statement with error checking
                $stmt = $conn->prepare("INSERT INTO pets (user_id, name, type, description, age, location, image_path, image_caption) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                if (!$stmt) {
                    die("SQL preparation failed: " . $conn->error);
                }

                $stmt->bind_param("isssisss", $userId, $petName, $petType, $petDescription, $petAge, $petLocation, $targetFile, $imageCaption);

                if ($stmt->execute()) {
                    $successMsg = "Pet added successfully!";
                } else {
                    $errorMsg = "Error saving pet details. Please try again.";
                }
                $stmt->close();
            } else {
                $errorMsg = "Error uploading image.";
            }
        } else {
            $errorMsg = "Invalid image type. Only JPG, PNG, and GIF files are allowed.";
        }
    } else {
        $errorMsg = "Please upload an image.";
    }
}

include('includes/nav.inc');
?>

<main class="container my-4 flex-grow-1">
    <h1 class="text-center mb-4">Add a Pet</h1>
    <p class="text-center mb-4">You can add a new pet here</p>

    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
    <?php elseif ($successMsg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <!-- Form fields for pet details -->
        <button type="submit" class="btn btn-primary btn-submit me-2">Submit</button>
        <button type="reset" class="btn btn-outline-secondary">Clear</button>
    </form>
</main>

<?php include('includes/footer.inc'); ?>
