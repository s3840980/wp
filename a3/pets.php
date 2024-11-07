<?php
session_start();
$title = "View Pets";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');


$stmt = $conn->prepare("SELECT petname, type, description, image, age, location FROM pets ORDER BY id DESC");
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>All Pets</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Pet Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Image</th>
            <th>Age</th>
            <th>Location</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pets as $pet): ?>
            <tr>
                <td><?php echo htmlspecialchars($pet['petname']); ?></td>
                <td><?php echo htmlspecialchars($pet['type']); ?></td>
                <td><?php echo htmlspecialchars($pet['description']); ?></td>
                <td>
                    <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['petname']); ?>" width="100">
                </td>
                <td><?php echo htmlspecialchars($pet['age']); ?></td>
                <td><?php echo htmlspecialchars($pet['location']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('includes/footer.inc.php'); ?>
