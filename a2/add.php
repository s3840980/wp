<?php
include('includes/db_connect.inc');
include('includes/header.inc');
include('includes/nav.inc');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $pet_name = htmlspecialchars(trim($_POST['pet-name']));
    $type = htmlspecialchars(trim($_POST['type']));
    $description = htmlspecialchars(trim($_POST['description']));
    $caption = htmlspecialchars(trim($_POST['image-caption']));
    $age = floatval($_POST['age']);
    $location = htmlspecialchars(trim($_POST['location']));

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "images/";
        $image_file = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_file;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $valid_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $valid_extensions)) {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            include('includes/footer.inc');
            exit;
        }
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // File upload was successful
        } else {
            echo "Error uploading the file.";
            include('includes/footer.inc');
            exit;
        }
    } else {
        echo "No image file uploaded or file upload error.";
        include('includes/footer.inc');
        exit;
    }

    $sql = "INSERT INTO pets (petname, type, description, age, location, image, caption) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisss", $pet_name, $type, $description, $age, $location, $image_file, $caption);

    if ($stmt->execute()) {
        echo "<p>Pet successfully added!</p>";
    } else {
        echo "<p>Error adding pet: " . $conn->error . "</p>";
    }

    $stmt->close();
}

?>

<main>
    <h2 class="page-title">Add a Pet</h2>
    <p class="description">You can add a new pet here</p>

    <!-- The form must use POST method and enctype for file uploads -->
    <form class="pet-form" action="add.php" method="POST" enctype="multipart/form-data">
        <label for="pet-name">Pet Name:</label>
        <input type="text" id="pet-name" name="pet-name" placeholder="Provide a name for the pet" required>

        <label for="type">Type: *</label>
        <select id="type" name="type" required>
            <option value="">--Choose an option--</option>
            <option value="cat">Cat</option>
            <option value="dog">Dog</option>
        </select>

        <label for="description">Description *</label>
        <textarea id="description" name="description" placeholder="Describe the pet briefly" required></textarea>

        <label for="image">Select an Image: *</label>
        <input type="file" id="image" name="image" required>
        <small class="image-info">Max image size: 500px</small>

        <label for="image-caption">Image Caption: *</label>
        <input type="text" id="image-caption" name="image-caption" placeholder="Describe the image in one word" required>

        <label for="age">Age (months): *</label>
        <input type="number" id="age" name="age" placeholder="Age of the pet in months" required>

        <label for="location">Location: *</label>
        <input type="text" id="location" name="location" placeholder="Location of the pet" required>

        <div class="form-buttons">
            <button type="submit" class="submit-button">Submit</button>
            <button type="reset" class="reset-button">Clear</button>
        </div>
    </form>
</main>

<?php
include('includes/footer.inc');
?>

<script src="js/main.js"></script>
