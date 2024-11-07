<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$title = "Edit Pet";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');

$pet_id = $_GET['id'];
$message = "";

$stmt = $conn->prepare("SELECT * FROM pets WHERE id = :id AND username = :username");
$stmt->bindParam(':id', $pet_id);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    echo "Pet not found or you do not have permission to edit this pet.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petname = $_POST['petname'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $caption = $_POST['caption'];
    $age = $_POST['age'];
    $location = $_POST['location'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = "images/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        } else {
            $message = "Failed to upload image. Please try again.";
        }
    } else {
        $image = $pet['image'];
    }

    try {
        $stmt = $conn->prepare("UPDATE pets SET petname = :petname, description = :description, image = :image, caption = :caption, age = :age, location = :location, type = :type WHERE id = :id AND username = :username");
        $stmt->bindParam(':petname', $petname);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':caption', $caption);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':type', $type);
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

<h2>Edit Pet</h2>
<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<form method="POST" action="" enctype="multipart/form-data">
    <label for="petname">Pet Name:</label>
    <input type="text" id="petname" name="petname" value="<?php echo htmlspecialchars($pet['petname']); ?>" required>

    <label for="type">Type:</label>
    <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($pet['type']); ?>" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($pet['description']); ?></textarea>

    <label for="caption">Image Caption:</label>
    <input type="text" id="caption" name="caption" value="<?php echo htmlspecialchars($pet['caption']); ?>" required>

    <label for="age">Age:</label>
    <input type="number" step="0.1" id="age" name="age" value="<?php echo htmlspecialchars($pet['age']); ?>" required>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($pet['location']); ?>" required>

    <label for="image">Pet Image (Leave empty to keep current image):</label>
    <input type="file" id="image" name="image" accept="image/*">

    <button type="submit" class="btn-custom">Update Pet</button>
</form>

<?php include('includes/footer.inc.php'); ?>
