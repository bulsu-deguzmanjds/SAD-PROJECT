<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $userID = $_POST["userID"];
    $advance = $_POST["advance"];
    $kaltas = $_POST["kaltas"];
    $adjustment = $_POST["adjustment"];
    $gadget = $_POST["gadget"];

    try{
        require_once("db.inc.php");

        $query = "INSERT INTO deductions (userID, cashAdvance, kaltas, adjustment, gadget) VALUES (?, ?, ?, ?, ?);";  

        $stmt = $pdo->prepare($query);

        $stmt->execute([$userID, $advance, $kaltas, $adjustment, $gadget]);

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