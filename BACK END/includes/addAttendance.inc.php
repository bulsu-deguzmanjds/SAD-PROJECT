<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employeeID = $_POST["employeeID"];
    $clockInTime = $_POST["clockInTime"];
    $clockOutTime = $_POST["clockOutTime"];

    try {
        // Include the database connection
        require_once("db.inc.php");

        // SQL query to insert attendance data
        $query = "
            INSERT INTO attendance (employeeID, clockInTime, clockOutTime) 
            VALUES (?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($query);

        // Execute the query with user inputs
        $stmt->execute([$employeeID, $clockInTime, $clockOutTime]);

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