<?php
try {
    // Include the database connection
    require_once("includes/db.inc.php");

    // Prepare the SELECT query to fetch salary data
    $query = "
        SELECT 
            grossSalary.salaryID, 
            users.FullName AS userFullName, 
            grossSalary.daysPresent, 
            grossSalary.rate, 
            grossSalary.overtimeHours, 
            grossSalary.overtimePay, 
            grossSalary.salary, 
            grossSalary.adjustment
        FROM grossSalary
        INNER JOIN users ON grossSalary.userID = users.userID";
        
    $stmt = $pdo->prepare($query);

    // Execute the query
    $stmt->execute();

    // Fetch all rows as an associative array
    $salaries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the database connection
    $pdo = null;
    $stmt = null;
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Salary Information</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Salary Information</h1>
    <table>
        <thead>
            <tr>
                <th>Salary ID</th>
                <th>Full Name</th>
                <th>Days Present</th>
                <th>Rate</th>
                <th>Overtime Hours</th>
                <th>Overtime Pay</th>
                <th>Salary</th>
                <th>Adjustment</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($salaries)): ?>
                <?php foreach ($salaries as $salary): ?>
                    <tr>
                        <td><?= htmlspecialchars($salary['salaryID']) ?></td>
                        <td><?= htmlspecialchars($salary['userFullName']) ?></td>
                        <td><?= htmlspecialchars($salary['daysPresent']) ?></td>
                        <td><?= htmlspecialchars($salary['rate']) ?></td>
                        <td><?= htmlspecialchars($salary['overtimeHours']) ?></td>
                        <td><?= htmlspecialchars($salary['overtimePay']) ?></td>
                        <td><?= htmlspecialchars($salary['salary']) ?></td>
                        <td><?= htmlspecialchars($salary['adjustment']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">No salary data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
