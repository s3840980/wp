<?php
session_start();
$title = "Search Pets";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');

$searchResults = [];
$keyword = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];

    
    $stmt = $conn->prepare("SELECT * FROM pets WHERE petname LIKE :keyword OR description LIKE :keyword OR type LIKE :keyword ORDER BY id DESC");
    $searchKeyword = '%' . $keyword . '%';
    $stmt->bindParam(':keyword', $searchKeyword);
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<h2>Search Pets</h2>

<!-- Search Form -->
<form method="POST" action="" class="search-form">
    <label for="keyword">Enter keyword:</label>
    <input type="text" id="keyword" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" required>
    <button type="submit" class="btn-custom">Search</button>
</form>

<!-- Search Results -->
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <h3>Search Results for "<?php echo htmlspecialchars($keyword); ?>"</h3>

    <?php if (count($searchResults) > 0): ?>
        <div class="gallery-container">
            <?php foreach ($searchResults as $pet): ?>
                <div class="gallery-item">
                    <a href="details.php?id=<?php echo htmlspecialchars($pet['id']); ?>">
                        <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['petname']); ?>" class="gallery-image">
                    </a>
                    <div class="gallery-caption">
                        <strong><?php echo htmlspecialchars($pet['petname']); ?></strong>
                        <p><?php echo htmlspecialchars($pet['caption']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No pets found matching your search criteria.</p>
    <?php endif; ?>
<?php endif; ?>

<?php include('includes/footer.inc.php'); ?>
