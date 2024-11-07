<?php
session_start();
$title = "Register";
include('includes/header.inc.php');
include('includes/db_connect.inc.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();
        $message = "Registration successful! You can now <a href='login.php'>log in</a>.";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<h2>Register</h2>
<?php if ($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>
<form method="POST" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="btn-custom">Register</button>
</form>

<?php include('includes/footer.inc.php'); ?>
