<?php
session_start();
$title = "Pets"; 
include('includes/header.inc.php');
include('includes/db_connect.inc.php');


$stmt = $conn->prepare("SELECT petname, type, description, image, age, location FROM pets ORDER BY petid DESC");
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>All Pets</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
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
                <td><img src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="Pet Image" width="100"></td>
                <td><?php echo htmlspecialchars($pet['age']); ?></td>
                <td><?php echo htmlspecialchars($pet['location']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('includes/footer.inc.php'); ?>
