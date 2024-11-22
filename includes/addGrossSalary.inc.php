<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userID = $_POST["userID"];
    $daysPresent = $_POST["daysPresent"];
    $rate = $_POST["rate"];
    $overtimeHours = $_POST["overtimeHours"];
    $overtimePay = $_POST["overtimePay"];
    $salary = $_POST["salary"];
    $adjustment = $_POST["adjustment"];

    try {
        // Include the database connection
        require_once("db.inc.php");

        // Prepare the INSERT query
        $query = "
            INSERT INTO grossSalary (
                userID, 
                daysPresent, 
                rate, 
                overtimeHours, 
                overtimePay, 
                salary, 
                adjustment
            ) 
            VALUES (?, ?, ?, ?, ?, ?, ?);
        ";

        // Prepare and execute the statement
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userID, $daysPresent, $rate, $overtimeHours, $overtimePay, $salary, $adjustment]);

        // Close the connection
        $pdo = null;
        $stmt = null;

        // Redirect on success
        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect if the request method is not POST
    header("Location: ../form.php");
    exit;
}

?>
