<?php
session_start();

// Debugging: Display session data to check if user is logged in
var_dump($_SESSION);

// Comment out the redirection temporarily to diagnose the issue
if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in. Please log in to add a pet.";
    // header("Location: login.php"); // Temporarily removed for debugging
    // exit();
} else {
    echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! You are logged in.";
}

$title = "Add a Pet";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');

$message = ""; // Variable to hold feedback messages

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petname = $_POST['petname'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $caption = $_POST['caption'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $username = $_SESSION['username']; // Use the logged-in user's username

    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = "images/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            try {
                $stmt = $conn->prepare("INSERT INTO pets (petname, description, image, caption, age, location, type, username) VALUES (:petname, :description, :image, :caption, :age, :location, :type, :username)");
                $stmt->bindParam(':petname', $petname);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image', $target_file);
                $stmt->bindParam(':caption', $caption);
                $stmt->bindParam(':age', $age);
                $stmt->bindParam(':location', $location);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                $message = "Pet added successfully!";
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
            }
        } else {
            $message = "Failed to upload image. Please try again.";
        }
    } else {
        $message = "Please select an image to upload.";
    }
}
?>

<h2>Add a New Pet</h2>
<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<form method="POST" action="" enctype="multipart/form-data">
    <label for="petname">Pet Name:</label>
    <input type="text" id="petname" name="petname" required>

    <label for="type">Type:</label>
    <input type="text" id="type" name="type" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="caption">Image Caption:</label>
    <input type="text" id="caption" name="caption" required>

    <label for="age">Age:</label>
    <input type="number" step="0.1" id="age" name="age" required>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required>

    <label for="image">Pet Image:</label>
    <input type="file" id="image" name="image" accept="image/*" required>

    <button type="submit" class="btn-custom">Add Pet</button>
</form>

<?php include('includes/footer.inc.php'); ?>
