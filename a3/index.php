<?php
$title = "Home - Pets Victoria";
include('includes/db_connect.inc');
include('includes/header.inc'); 
include('includes/nav.inc'); 

$query = "SELECT petid, petname, image FROM pets ORDER BY petid DESC LIMIT 4";
$result = $conn->query($query);
?>

<section class="homepet-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div id="petCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $first = true; ?>
                            <?php while ($pet = $result->fetch_assoc()): ?>
                                <div class="carousel-item <?= $first ? 'active' : ''; ?>">
                                    <img src="<?= htmlspecialchars($pet['image']) ?>" alt="<?= htmlspecialchars($pet['petname']) ?>" class="img-fluid rounded carousel-image">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5><?= htmlspecialchars($pet['petname']) ?></h5>
                                    </div>
                                </div>
                                <?php $first = false; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="carousel-item active">
                                <img src="images/placeholder.jpg" alt="No pets available" class="d-block w-100 carousel-image">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>No Pets Available</h5>
                                </div>
                            </div>
                        <?php endif; ?>
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
            </div>
            <div class="col-md-6 text-center text-md-start">
                <h1 class="home-title text-center">PETS VICTORIA</h1>
                <h3 class="home-subtitle text-center">WELCOME TO PET ADOPTION</h3>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.inc'); ?>
