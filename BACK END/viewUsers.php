<?php
try {
    // Include the database connection
    require_once("includes/db.inc.php");

    // Prepare the SELECT query to fetch user information
    $query = "SELECT userID, FullName, Email FROM users";
    $stmt = $pdo->prepare($query);

    // Execute the query
    $stmt->execute();

    // Fetch all rows as an associative array
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>View Users</title>
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
    <h1 style="text-align: center;">User Information</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['userID']) ?></td>
                        <td><?= htmlspecialchars($user['FullName']) ?></td>
                        <td><?= htmlspecialchars($user['Email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center;">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
