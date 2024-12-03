<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employeeID = $_POST['employeeID']; // Ensure employeeID is passed in the form
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

        // SQL query to update employee data
        $query = "UPDATE employee 
                  SET firstName = ?, lastName = ?, email = ?, contactNumber = ?, rate = ?, 
                      team = ?, employeeType = ?, dateHired = ?, employeeCode = ?
                  WHERE employeeID = ?";

        // Prepare and execute the statement
        $stmt = $pdo->prepare($query);
        $stmt->execute([$firstName, $lastName, $email, $contactNumber, $rate, $team, $employeeType, $dateHired, $employeeCode, $employeeID]);

        // Clean up and redirect
        $pdo = null;
        $stmt = null;

        header("Location: ../../FRONT END/employeeList.php"); // Redirect to employee list or confirmation page
        exit();
    } catch (PDOException $e) {
        // Handle errors
        die("Error updating employee: " . $e->getMessage());
    }
} else {
    // Redirect if accessed without form submission
    header("Location: ../editEmployeeForm.html"); // Redirect to the edit form page
    exit();
}
?>
