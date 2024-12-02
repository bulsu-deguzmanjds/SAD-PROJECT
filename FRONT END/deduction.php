<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deductions</title>
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
            background-color: white;
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

        

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-btn {
            padding: 10px 20px;
            background-color: #0033cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .add-btn:hover {
            background-color: #002288;
        }

        .search-box {
            display: flex;
            align-items: center;
        }

        .search-box input {
            padding: 5px 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-box label {
            margin-right: 10px;
            font-size: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
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

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
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
    <body>
        <div class="sidebar">
            <h1>VILLAFUERTE</h1>
            <h2>DESIGN-BUILDERS</h2>
            <a href="dashboardpage.html"><button class="add-btn"> DASHBOARD</button></a>
            <select id="employee" onchange="navigateToPage()">
                <option selected disabled>EMPLOYEE</option>
                <option value="employeelist.php">Employee list</option>
                
                <option value="salary.php">Salary</option>
                <option value="deduction.php">Deduction</option>
            </select>
            <a href="attendance.php"><button>ATTENDANCE</button></a>
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
            <h1>Deductions Information</h1>
            <a href="adddeduction.php"><button class="add-btn"> + ADD</button></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>DEDUCTION ID</th>
                    <th>EMPLOYEE NAME</th>
                    <th>CASH ADVANCE</th>
                    <th>KALTAS</th>
                    <th>ADJUSTMENT</th>
                    <th>GADGET</th>
                    <th>TOTAL DEDUCTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Include database connection
                    require_once("../BACK END/includes/db.inc.php");
    
                    // Query to fetch deduction data along with employee names
                    $query = "SELECT d.deductionID, e.firstName, e.lastName, d.cashAdvance, 
                                 d.kaltas, d.adjustment, d.gadget, d.totalDeduction
                              FROM deductions d
                              JOIN employee e ON d.employeeID = e.employeeID";
    
                    // Prepare and execute the query
                    $stmt = $pdo->query($query);
    
                    // Loop through the results and display each deduction entry
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['deductionID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstName']) . " " . htmlspecialchars($row['lastName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['cashAdvance']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kaltas']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['adjustment']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['gadget']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['totalDeduction']) . "</td>";
                        echo "</tr>";
                    }
    
                    // Clean up
                    $pdo = null;
                    $stmt = null;
    
                } catch (PDOException $e) {
                    die("Error fetching deductions data: " . $e->getMessage());
                }
                ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>