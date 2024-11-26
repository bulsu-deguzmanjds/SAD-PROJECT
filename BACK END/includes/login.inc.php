<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve login data
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        // Include the database connection
        require_once("db.inc.php");

        // Query to find the user by email
        $query = "SELECT userID, FullName, Pass FROM users WHERE Email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and passwords match
        if ($user && $user["Pass"] === $password) {
            // Successful login
            session_start();
            $_SESSION["userID"] = $user["id"];
            $_SESSION["userName"] = $user["FullName"];
            
            // Redirect to the user's dashboard or homepage
            header("Location: ../../FRONT END/dashboardpage.html");
            die("");
        } else {
            // Invalid email or password
            header("Location: ../../FRONT END/login.php");
            die("");
        }
    } catch (PDOException $e) {
        // Handle database errors
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect if the request method is not POST
    header("Location: ../../FRONT END/login.php");
    die("");
}
