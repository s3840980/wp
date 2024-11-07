<?php
$query_users = "SELECT DISTINCT username FROM users WHERE id IN (SELECT DISTINCT user_id FROM pets)";
$result_users = $conn->query($query_users);
?>

<footer class="footer text-center mt-5">
    <div class="container">
        <!--<div>
            <?php if ($result_users && $result_users->num_rows > 0): ?>
                <div class="d-inline-flex flex-wrap justify-content-center">
                    <?php while ($user = $result_users->fetch_assoc()): ?>
                        <div class="me-3"> 
                            <a href="users.php?username=<?= urlencode($user['username']) ?>" class="text-decoration-none text-muted">
                                <?= htmlspecialchars($user['username']) ?>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No users have uploaded pets yet.</p>
            <?php endif; ?>
        </div> -->
        <p class="mb-0">&copy; Copyright Robert Voluntad S3840980 2024. All Rights Reserved </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
