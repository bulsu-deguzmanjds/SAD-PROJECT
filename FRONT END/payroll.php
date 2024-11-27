<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
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

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .date-input {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 150px;
        }

        .action-buttons button {
            padding: 10px 20px;
            font-size: 1rem;
            margin-left: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .action-buttons .payroll-btn {
            background-color: #28a745;
        }

        .action-buttons .payslip-btn {
            background-color: #007bff;
        }

        .action-buttons button:hover {
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #0033cc;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h1>VILLAFUERTE</h1>
            <h2>DESIGN-BUILDERS</h2>
            <a href="dashboardpage.html"><button>DASHBOARD</button></a>
            <select id="employee" onchange="navigateToPage()">
                <option selected disabled>EMPLOYEE</option>
                <option value="employeelist.php">Employee list</option>
                
                <option value="salary.php">Salary</option>
                <option value="deduction.php">Deduction</option>
            </select>
            <a href="attendance.php"><button>ATTENDANCE</button></a>
            <a href="task.html"><button>TASK</button></a>
            <a href="payroll.php"><button>PAYROLL</button></a>
           <a href="login.html"><button>LOGOUT</button></a> 
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
                <div class="action-buttons">
                    <button class="payslip-btn">PRINT PAYSLIP</button>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>EMPLOYEE ID</th>
                        <th>EMPLOYEE NAME</th>
                        <th>GROSS</th>
                        <th>DEDUCTION</th>
                        <th>NET PAY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        // Include database connection
                        require_once("../BACK END/includes/db.inc.php");

                        // Query to fetch gross salary data along with deductions and cash advance
                        $query = "SELECT    gs.salaryID, 
                                            e.firstName, 
                                            e.lastName, 
                                            gs.salary AS gross, 
                                            d.totalDeduction AS deduction, 
                                            (gs.salary - d.totalDeduction) AS netPay
                                    FROM grossSalary gs
                                    JOIN employee e ON gs.employeeID = e.employeeID
                                    JOIN deductions d ON d.employeeID = e.employeeID";

                        // Prepare and execute the query
                        $stmt = $pdo->query($query);

                        // Loop through the results and display each employee's gross salary data
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['salaryID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['firstName']) . " " . htmlspecialchars($row['lastName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['gross']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['deduction']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['netPay']) . "</td>";
                            echo "</tr>";
                        }

                        // Clean up
                        $pdo = null;
                        $stmt = null;

                    } catch (PDOException $e) {
                        die("Error fetching gross salary data: " . $e->getMessage());
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>