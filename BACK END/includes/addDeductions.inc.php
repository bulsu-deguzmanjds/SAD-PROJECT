<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $employeeID = $_POST["employeeID"];
    $advance = $_POST["advance"];
    $kaltas = $_POST["kaltas"];
    $adjustment = $_POST["adjustment"];
    $gadget = $_POST["gadget"];
    $totalDeduction = $advance + $adjustment + $kaltas + $gadget;

    try{
        require_once("db.inc.php");

        $query = "INSERT INTO deductions (employeeID, cashAdvance, kaltas, adjustment, gadget, totalDeduction) VALUES (?, ?, ?, ?, ?, ?);";  

        $stmt = $pdo->prepare($query);

        $stmt->execute([$employeeID, $advance, $kaltas, $adjustment, $gadget, $totalDeduction]);

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