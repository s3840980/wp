<?php
include('includes/db_connect.inc');
include('includes/header.inc');
include('includes/nav.inc');

$sql = "SELECT petid, petname, type, age, location FROM pets";
$result = $conn->query($sql);
?>

<main>
    <h2 class="page-title">Discover Pets Victoria</h2>
    <p class="description">
        Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to connect these deserving pets with caring individuals and families, creating lifelong bonds. The organization offers a range of services, including adoption counseling, pet education, and community support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless animals.
    </p>
    
    <div class="table-content">
        <img src="images/pets.jpeg" alt="dogs and cats running" class="pets-image">
        <table class="pets-table">
            <tr>
                <th>Pet</th>
                <th>Type</th>
                <th>Age</th>
                <th>Location</th>
            </tr>

            <?php
            
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='details.php?id=" . $row["petid"] . "'>" . $row["petname"] . "</a></td>";
                    echo "<td>" . $row["type"] . "</td>";
                    echo "<td>" . $row["age"] . " months</td>";
                    echo "<td>" . $row["location"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No pets available</td></tr>";
            }
            ?>
        </table>
    </div>
</main>

<?php
include('includes/footer.inc');
?>

<script src="js/main.js"></script>
