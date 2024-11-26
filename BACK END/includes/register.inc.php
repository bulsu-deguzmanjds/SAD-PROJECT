<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST["fullname"];
    $password = $_POST["pwd"];
    $email = $_POST["email"];

    try{
        require_once("db.inc.php");

        $query = "INSERT INTO users (FullName, Pass, Email) VALUES (?, ?, ?);";  

        $stmt = $pdo->prepare($query);

        $stmt->execute([$username, $password, $email]);

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