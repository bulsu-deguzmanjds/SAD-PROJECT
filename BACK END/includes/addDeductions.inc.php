<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $employeeID = $_POST["employeeID"];
    $advance = $_POST["advance"];
    $adjustment = $_POST["adjustment"];
    $totalDeduction = $advance + $adjustment;

    try{
        require_once("db.inc.php");

        $query = "INSERT INTO deductions (employeeID, cashAdvance, adjustment, totalDeduction) VALUES (?, ?, ?, ?);";  

        $stmt = $pdo->prepare($query);

        $stmt->execute([$employeeID, $advance, $adjustment, $totalDeduction]);

        $pdo = null;
        $stmt = null;

        header("Location: ../index.php");

        die("");
    }
    catch(PDOException $e){
        die("Query failed: " . $e->getMessage()); 
    }
}
else
{
    header("Location: ../test.php");
}