<?php
session_start();
$title = "Home - Pets Victoria"; 
include('includes/header.inc.php'); 
include('includes/db_connect.inc.php'); 


$stmt = $conn->prepare("SELECT petname, image, caption FROM pets ORDER BY id DESC LIMIT 4");
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<header>
    <h1>Welcome to Pets Victoria</h1>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! You are logged in.</p>
        <p>Welcome to Pets Victoria! You can <a href="pets.php">view all pets</a> or <a href="add.php">add a new pet</a>.</p>
        <a href="logout.php" class="btn-custom">Logout</a>
    <?php else: ?>
        <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to access more features.</p>
    <?php endif; ?>
</header>


<div id="petCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        
        $first = true;
        foreach ($pets as $pet): ?>
            <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($pet['petname']); ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?php echo htmlspecialchars($pet['petname']); ?></h5>
                    <p><?php echo htmlspecialchars($pet['caption']); ?></p>
                </div>
            </div>
            <?php $first = false; ?>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php include('includes/footer.inc.php'); ?>
