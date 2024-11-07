<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

include('includes/db_connect.inc.php'); 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    
    
    try {
        $stmt = $conn->prepare("INSERT INTO pets (name, type, description, user_id) VALUES (:name, :type, :description, :user_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $_SESSION['user_id']); 
        $stmt->execute();
        
        
        header("Location: pets.php"); 
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Pet</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Add a New Pet</h2>
    <form method="POST" action="">
        <label for="name">Pet Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <button type="submit" class="btn-custom">Add Pet</button>
    </form>
</body>
</html>
