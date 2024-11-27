<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-color: #333333;
        }
        .sidebar {
    background-color: #002080;
    width: 20%;
    color: white;
    padding: 1.5rem;
    border-right: solid red 10px;
    text-align: center;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
}

        .sidebar h1 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: white;   
        }

        .sidebar h2 {
            font-size: 1rem;
            font-weight: normal;
            margin-bottom: 30px;
            color: white;
        }

        .sidebar button, .sidebar select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1.5rem;
            background-color: #0056b3;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            color: white;
        }

        .sidebar button:hover {
            background-color: #8e0000;
        }

        .sidebar select:hover {
            background-color: #004080;
            color: white; 
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .table-container {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #747373;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #0033cc;
            color: white;
        }

        .add-btn {
            padding: 10px 20px;
            background-color: #006421;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-btn:hover {
            background-color: #000000;
        }

        .search-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #008234;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .tools button {
            margin: 0 5px;
            padding: 5px 10px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .tools .edit {
            background-color: #076900;
        }

        .tools .edit:hover {
            background-color:#076900;
        }

        .tools .delete {
            background-color: #dc3545;
        }

        .tools .delete:hover {
            background-color: #b02a37;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>VILLAFUERTE</h1>
        <h2>DESIGN-BUILDERS</h2>
        <button>DASHBOARD</button>
        <select id="employee" onchange="navigateToPage()">
            <option selected disabled>EMPLOYEE</option>
            <option value="employeelist.php">Employee list</option>
            <option value="salary.php">Salary</option>
            <option value="deduction.php">Deduction</option>
        </select>
        <a href="attendance.html"><button>ATTENDANCE</button></a>
        <a href="task.html"><button>TASK</button></a>
        <a href="payroll.php"><button>PAYROLL</button></a>
        <button>LOGOUT</button>
    </div>
    
    <script>
        function navigateToPage() {
            const selectedPage = document.getElementById("employee").value;
    
            if (selectedPage) {
                window.location.href = selectedPage;
            }
        }
    </script>
    <div class="main-content">
        <div class="top-bar">
            <h1>Salary Information</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th>SALARY ID</th>
                    <th>EMPLOYEE NAME</th>
                    <th>DAYS PRESENT</th>
                    <th>RATE</th>
                    <th>OVERTIME HOURS</th>
                    <th>OVERTIME PAY</th>
                    <th>GROSS SALARY</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Include database connection
                    require_once("../BACK END/includes/db.inc.php");
    
                    // Query to fetch salary data along with employee names
                    $query = "SELECT gs.salaryID, e.firstName, e.lastName, gs.daysPresent, 
                                 gs.rate, gs.overtimeHours, gs.overtimePay, 
                                 gs.salary
                              FROM grossSalary gs
                              JOIN employee e ON gs.employeeID = e.employeeID";
    
                    // Prepare and execute the query
                    $stmt = $pdo->query($query);
    
                    // Loop through the results and display each salary entry
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['salaryID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstName']) . " " . htmlspecialchars($row['lastName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['daysPresent']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['rate']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['overtimeHours']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['overtimePay']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
                        echo "<td class='tools'>
                                <button class='edit'>Edit</button>
                                <button class='delete'>Delete</button>
                              </td>";
                        echo "</tr>";
                    }
    
                    // Clean up
                    $pdo = null;
                    $stmt = null;
    
                } catch (PDOException $e) {
                    die("Error fetching salary data: " . $e->getMessage());
                }
                ?>
            </tbody>
        </table>
    </div>    
</body>
</html>