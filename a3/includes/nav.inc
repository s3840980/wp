<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-paw"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="pets.php">Pets</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="petTypeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Gallery
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petTypeDropdown">
                        <li><a class="dropdown-item" href="gallery.php">All Types</a></li>
                        <?php
                        include('include/db_connect.inc');
                        
                        $typeQuery = "SELECT DISTINCT type FROM pets";
                        $typeResult = $conn->query($typeQuery);
                        while ($row = $typeResult->fetch_assoc()) {
                            echo '<li><a class="dropdown-item" href="gallery.php?pet_type=' . urlencode($row['type']) . '">' . htmlspecialchars($row['type']) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <?php
                if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
                    echo '<li class="nav-item"><a class="nav-link" href="add.php">Add Pet</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="user.php">My Pets</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                }
                ?>
            </ul>
            <form class="d-flex" method="GET" action="navsearch.php">
                <input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
