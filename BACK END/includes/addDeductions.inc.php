<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $employeeID = $_POST["employeeID"];
    $advance = $_POST["cashAdvance"];
    $adjustment = $_POST["adjustment"];
    $totalDeduction = $advance + $adjustment;

    try{
        require_once("db.inc.php");

        $query = "
            INSERT INTO deductions (employeeID, cashAdvance, adjustment, totalDeduction) 
            VALUES (?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE
                cashAdvance = VALUES(cashAdvance),
                adjustment = VALUES(adjustment),
                totalDeduction = VALUES(totalDeduction);
        ";

        $stmt = $pdo->prepare($query);

        $stmt->execute([$employeeID, $advance, $adjustment, $totalDeduction]);

        $pdo = null;
        $stmt = null;

        header("Location: ../../FRONT END/deduction.php");

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