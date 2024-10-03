<?php
include('includes/db_connect.inc');
include('includes/header.inc');
include('includes/nav.inc');

if (isset($_GET['id'])) {
    $petid = intval($_GET['id']); // Sanitize the pet ID

    $stmt = $conn->prepare("SELECT petname, description, type, age, location, image, caption FROM pets WHERE petid = ?");
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Pet not found.</p>";
        include('includes/footer.inc');
        exit;
    }
} else {
    echo "<p>No pet ID provided.</p>";
    include('includes/footer.inc');
    exit;
}
?>

<main>
    <h2 class="page-title"><?php echo $row['petname']; ?></h2>
    <div class="pet-details">
        <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['caption']; ?>" class="pet-image">
        <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
        <p><strong>Type:</strong> <?php echo $row['type']; ?></p>
        <p><strong>Age:</strong> <?php echo $row['age']; ?> months</p>
        <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
    </div>
</main>

<?php
// Include the footer
include('includes/footer.inc');
?>


