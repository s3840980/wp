<?php
include('includes/db_connect.inc');
include('includes/header.inc');
include('includes/nav.inc');

$sql = "SELECT petid, petname, image, caption FROM pets";
$result = $conn->query($sql);
?>

<main>
    <h2 class="page-title">Pets Victoria has a lot to offer!</h2>
    <p class="description">For almost two decades, Pets Victoria has helped in creating true social change by bringing pet adoption into the mainstream. Our work has helped make a difference to the Victorian rescue community and thousands of pets in need of rescue and rehabilitation. But, until every pet is safe, respected, and loved, we all still have big, hairy work to do.</p>
    
    <div class="gallery">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each pet in the gallery
            while($row = $result->fetch_assoc()) {
                echo '<div class="gallery-item">';
                echo '<a href="details.php?id=' . $row['petid'] . '">';
                echo '<img src="images/' . $row['image'] . '" alt="' . $row['caption'] . '">';
                echo '<div class="overlay"><p>Discover More!</p></div>';
                echo '</a>';
                echo '<p>' . $row['petname'] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No pets available for the gallery.</p>';
        }
        ?>
    </div>
</main>

<?php
include('includes/footer.inc');
?>


