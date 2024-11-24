<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userID = $_POST["userID"];
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];

    try {
        // Include the database connection
        require_once("db.inc.php");

        // Check if the user exists and the current password matches
        $query = "SELECT Pass FROM users WHERE userID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userID]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user["Pass"] === $currentPassword) {
            // Update the password
            $updateQuery = "UPDATE users SET Pass = ? WHERE userID = ?";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$newPassword, $userID]);

            $pdo = null;
            $stmt = null;

            header("Location: ../index.php?message=passwordChanged");
            die("");
        } else {
            die("Invalid user ID or current password.");
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../changePasswordForm.php");
    die("");
}
