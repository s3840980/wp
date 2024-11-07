<?php
session_start();
include('includes/db_connect.inc');
include('includes/header.inc');

$errorMsg = $successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check for required fields and matching passwords
    if (!$username || !$password || !$confirmPassword) {
        $errorMsg = "All fields marked with * are required.";
    } elseif ($password !== $confirmPassword) {
        $errorMsg = "Passwords do not match.";
    } else {
        // Hash the password using SHA-1
        $hashedPassword = sha1($password);

        // Prepare SQL statement to insert the new user
        $stmt = $conn->prepare("INSERT INTO users (username, password, reg_date) VALUES (?, ?, NOW())");
        
        if (!$stmt) {
            die("SQL preparation failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            $successMsg = "Registration successful! You can now log in.";
        } else {
            $errorMsg = "An error occurred: " . $stmt->error;
        }
        $stmt->close();
    }
}

include('includes/nav.inc'); 
?>

<main class="container my-5">
    <h1 class="text-center mb-4">Register</h1>
    <p class="text-center mb-4">Create your account here</p>

    <!-- Display messages -->
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
    <?php elseif ($successMsg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>

    <form class="needs-validation" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control" id="username" value="<?= htmlspecialchars($username ?? '') ?>" required>
            <div class="invalid-feedback">Please choose a username.</div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" id="password" required>
            <div class="invalid-feedback">Please provide a password.</div>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password<span class="text-danger">*</span></label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
            <div class="invalid-feedback">Please confirm your password.</div>
        </div>

        <div class="text-center">
            <button class="btn btn-primary" type="submit">Register</button>
            <button class="btn btn-outline-secondary" type="reset">Clear</button>
        </div>
    </form>
</main>

<?php include('includes/footer.inc'); ?>
