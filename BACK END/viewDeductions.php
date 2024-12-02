<?php
try {
    // Include the database connection
    require_once("includes/db.inc.php");

    // Prepare the SELECT query
    $query = "
        SELECT 
            deductions.deductionID, 
            users.fullName AS userFullName, 
            deductions.cashAdvance, 
            deductions.adjustment, 
            deductions.totalDeductions
        FROM deductions
        INNER JOIN users ON deductions.userID = users.userID";
    $stmt = $pdo->prepare($query);

    // Execute the query
    $stmt->execute();

    // Fetch all rows
    $deductions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the connection
    $pdo = null;
    $stmt = null;
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Deductions</title>
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
    <h1 style="text-align: center;">Deductions Information</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Cash Advance</th>
                <th>Adjustment</th>
                <th>Total Deductions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($deductions)): ?>
                <?php foreach ($deductions as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['deductionID']) ?></td>
                        <td><?= htmlspecialchars($row['userFullName']) ?></td>
                        <td><?= htmlspecialchars($row['cashAdvance']) ?></td>
                        <td><?= htmlspecialchars($row['adjustment']) ?></td>
                        <td><?= htmlspecialchars($row['totalDeductions']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
