<?php
$title = "Home - Pets Victoria";
include('includes/db_connect.inc');
include('includes/header.inc'); 
include('includes/nav.inc'); 

$query = "SELECT id, name, image_path FROM pets ORDER BY id DESC LIMIT 4";
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
                                    <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="img-fluid rounded carousel-image">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5><?= htmlspecialchars($pet['name']) ?></h5>
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

<section class="search-section">
    <div class="container">
        <form method="GET" action="search.php" class="row">
            <div class="col-md-8 mb-3 mb-md-0">
                <input type="text" name="keyword" class="form-control" placeholder="I am looking for ...">
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <select name="pet_type" class="form-select">
                    <option value="">Select your pet type</option>
                    <option value="dog">Dogs</option>
                    <option value="cat">Cats</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</section>

<section class="content-section py-5">
    <div class="container">
        <h1 class="mb-4 text-center">Discover Pets Victoria</h1>
        <p>Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to connect these deserving pets with caring individuals and families, creating lifelong bonds. The organization offers a range of services, including adoption counseling, pet education, and community support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless animals.</p>
    </div>
</section>

<?php include('includes/footer.inc'); ?>
