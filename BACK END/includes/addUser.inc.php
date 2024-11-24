<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $fullName = $_POST["fullName"];
    $password = $_POST["password"];

    try {
        // Include the database connection
        require_once("db.inc.php");

        // SQL query to insert user data
        $query = "
            INSERT INTO users (Email, FullName, Pass) 
            VALUES (?, ?, ?)
        ";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($query);

        // Execute the query with user inputs
        $stmt->execute([$email, $fullName, $password]);

        // Close the database connection
        $pdo = null;
        $stmt = null;

        // Redirect to a success page or back to the form
        header("Location: ../index.php");
        die("");
    } catch (PDOException $e) {
        // Handle errors
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect if the request method is not POST
    header("Location: ../form.php");
    die("");
}
