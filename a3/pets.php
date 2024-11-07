<?php
$title = "Pets Page";
include('includes/db_connect.inc');
include('includes/header.inc'); 
include('includes/nav.inc'); 

$query = "SELECT petname, type, age, location, image FROM pets";
$result = $conn->query($query);
?>

<main class="container my-4 flex-grow-1">
    <h1 class="text-center mb-4">Discover Pets Victoria</h1>
    <p class="text-center mb-4">
        Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to connect these deserving pets with caring individuals and families, creating lifelong bonds. The organization offers a range of services, including adoption counseling, pet education, and community support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless animals.
    </p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Pet</th>
                    <th>Type</th>
                    <th>Age</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($pet = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($pet['petname']) ?></td>
                            <td><?= htmlspecialchars($pet['type']) ?></td>
                            <td><?= htmlspecialchars($pet['age']) ?> months</td>
                            <td><?= htmlspecialchars($pet['location']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No pets available at the moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
