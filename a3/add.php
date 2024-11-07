<?php
session_start();
$title = "Add Pets Page";
include('include/db_connect.inc');
include('include/header.inc');


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
                
                $stmt = $conn->prepare("INSERT INTO pets (user_id, name, type, description, age, location, image_path, image_caption) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
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

include('include/nav.inc');
?>

<main class="container my-4 flex-grow-1">
    <h1 class="text-center mb-4">Add a Pet</h1>
    <p class="text-center mb-4">You can add a new pet here</p>

    <!-- Display messages -->
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
    <?php elseif ($successMsg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>

    <!-- Pet Form -->
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
            <label for="petName" class="form-label">Pet Name: <span class="text-danger">*</span></label>
            <input type="text" name="petName" class="form-control" id="petName" placeholder="Provide a name for the pet" required>
        </div>

        <div class="mb-3">
            <label for="petType" class="form-label">Type: <span class="text-danger">*</span></label>
            <select name="petType" class="form-select" id="petType" required>
                <option selected disabled value="">--Choose an option--</option>
                <option>Dog</option>
                <option>Cat</option>
                <option>Bird</option>
                <option>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="petDescription" class="form-label">Description: <span class="text-danger">*</span></label>
            <textarea name="petDescription" class="form-control" id="petDescription" rows="3" placeholder="Describe the pet briefly" required></textarea>
        </div>

        <div class="mb-3">
            <label for="petImage" class="form-label">Select an Image: <span class="text-danger">*</span></label>
            <input type="file" name="petImage" class="form-control" id="petImage" accept="image/*" required>
            <div class="form-text">MAX IMAGE SIZE: 500PX</div>
        </div>

        <div class="mb-3">
            <label for="imageCaption" class="form-label">Image Caption: <span class="text-danger">*</span></label>
            <input type="text" name="imageCaption" class="form-control" id="imageCaption" placeholder="Describe the image in one word" required>
        </div>

        <div class="mb-3">
            <label for="petAge" class="form-label">Age (months): <span class="text-danger">*</span></label>
            <input type="number" name="petAge" class="form-control" id="petAge" placeholder="Age of a pet in months" required>
        </div>

        <div class="mb-3">
            <label for="petLocation" class="form-label">Location: <span class="text-danger">*</span></label>
            <input type="text" name="petLocation" class="form-control" id="petLocation" placeholder="Location of the pet" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-submit me-2">Submit</button>
            <button type="reset" class="btn btn-outline-secondary">Clear</button>
        </div>
    </form>
</main>

<?php include('include/footer.inc'); ?>
