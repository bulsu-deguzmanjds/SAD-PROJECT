<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $rate = $_POST['rate'];
    $team = $_POST['team'];
    $employeeType = $_POST['employeeType'];
    $dateHired = $_POST['dateHired'];
    $employeeCode = $_POST['employeeCode'];

    try {
        // Include database connection
        require_once("db.inc.php");

        // SQL query to insert employee data
        $query = "INSERT INTO employee (firstName, lastName, email, rate, contactNumber, team, employeeType, dateHired, employeeCode) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        // Prepare and execute the statement
        $stmt = $pdo->prepare($query);
        $stmt->execute([$firstName, $lastName, $email, $rate, $contactNumber, $team, $employeeType, $dateHired, $employeeCode]);

        // Clean up and redirect
        $pdo = null;
        $stmt = null;

        header("Location: ../../FRONT END/employeeList.php"); // Redirect to homepage or confirmation page
        exit();
    } catch (PDOException $e) {
        // Handle errors
        die("Error adding employee: " . $e->getMessage());
    }
} else {
    // Redirect if accessed without form submission
    header("Location: ../addEmployeeForm.html"); 
    exit();
}
?>
