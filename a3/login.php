<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = "Login Page";
include('includes/db_connect.inc'); 
include('includes/header.inc'); 

$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!$username || !$password) {
        $errorMsg = "Please provide both username and password.";
    } else {
        // Prepare SQL statement to retrieve the user with the given username
        $stmt = $conn->prepare("SELECT userID, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $username, $hashedPassword);
            $stmt->fetch();

            // Verify the password using SHA-1
            if (sha1($password) === $hashedPassword) {
                // Set session variables
                $_SESSION["id"] = $id;
                $_SESSION['username'] = $username;
                header("Location: user.php"); 
                exit();
            } else {
                $errorMsg = "Invalid username or password.";
            }
        } else {
            $errorMsg = "No account found with that username.";
        }
        $stmt->close();
    }
}

include('includes/nav.inc'); 
?>

<main class="container my-5">
    <h1 class="text-center mb-4">Login</h1>
    <p class="text-center mb-4">Please enter your credentials to login</p>

    <!-- Display error message -->
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>

    <form class="needs-validation" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control" id="username" required>
            <div class="invalid-feedback">Please provide a username.</div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" id="password" required>
            <div class="invalid-feedback">Please provide your password.</div>
        </div>

        <div class="text-center">
            <button class="btn btn-primary" type="submit">Login</button>
            <button class="btn btn-outline-secondary" type="reset">Clear</button>
        </div>
    </form>

    <div class="text-center mt-3">
        <p>Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a></p>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
