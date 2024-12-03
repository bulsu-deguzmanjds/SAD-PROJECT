<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll</title>
    <link rel="stylesheet" href="styles.css">
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

        .content {
            flex: 1;
            padding: 20px;
            background-color: #f0f0f0;
        }
        
        h3 {
            margin-bottom: 10px;
        }
        
        .payroll-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .payroll-table th, .payroll-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        
        .payroll-table th {
            background-color: #ccc;
            font-weight: bold;
        }
        
        tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .signature {
            width: 45%;
            text-align: center;
        }
        
        .signature hr {
            border: 0;
            border-top: 2px solid black;
            margin: 10px 0;
        }
        
        .print-btn {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .print-btn:hover {
            background-color: #218838;
        }

        /* Print-specific styles */
        @media print {
            body {
                display: block;
            }

            .sidebar {
                display: none;
            }

            .content {
                margin: 0 auto;
                width: 100%;
                background-color: white;
                color: black;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>VILLAFUERTE</h1>
        <h2>DESIGN-BUILDERS</h2>
        <a href="dashboardPage.html"><button class="add-btn">DASHBOARD</button></a>
        <select id="employee" onchange="navigateToPage()">
            <option selected disabled>EMPLOYEE</option>
            <option value="employeeList.php">Employee list</option>
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

        function printPayslip() {
            window.print();
        }
    </script>

    <?php
    // Assuming you have a database connection file included
    require_once('../BACK END/includes/db.inc.php');

    // Get the employeeID (you can get this via GET or POST, or session)
    $employeeID = $_POST['employeeID']; // For example

    // Query to fetch earnings (salary and overtime) and deductions (cash advance and adjustment)
    $query = "
        SELECT e.firstName, e.lastName, 
            SUM(grossSalary.salary) AS totalSalary, 
            SUM(grossSalary.overtimePay) AS totalOvertimePay, 
            SUM(deductions.cashAdvance) AS totalCashAdvance,
            SUM(deductions.adjustment) AS totalAdjustment
        FROM employee e
        LEFT JOIN grossSalary ON e.employeeID = grossSalary.employeeID
        LEFT JOIN deductions ON e.employeeID = deductions.employeeID
        WHERE e.employeeID = ?
        GROUP BY e.employeeID
    ";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute([$employeeID]);

    // Fetch the employee data
    $employeeData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get individual earnings (salary and overtime) and deductions (cash advance and adjustment)
    $earningsQuery = "
        SELECT salary, overtimePay FROM grossSalary WHERE employeeID = ?
    ";
    $earningsStmt = $pdo->prepare($earningsQuery);
    $earningsStmt->execute([$employeeID]);
    $earnings = $earningsStmt->fetchAll(PDO::FETCH_ASSOC);

    $deductionsQuery = "
        SELECT cashAdvance, adjustment FROM deductions WHERE employeeID = ?
    ";
    $deductionsStmt = $pdo->prepare($deductionsQuery);
    $deductionsStmt->execute([$employeeID]);
    $deductions = $deductionsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the net pay
    $totalSalary = $employeeData['totalSalary'];
    $totalOvertimePay = $employeeData['totalOvertimePay'];
    $totalCashAdvance = $employeeData['totalCashAdvance'];
    $totalAdjustment = $employeeData['totalAdjustment'];
    $totalEarnings = $totalSalary + $totalOvertimePay;
    $totalDeductions = $totalCashAdvance + $totalAdjustment;
    $netPay = $totalEarnings - $totalDeductions;
    ?>



<div class="content">
    <h3>EMPLOYEE ID: <?php echo $employeeID; ?></h3>
    <h3>EMPLOYEE NAME: <?php echo $employeeData['firstName'] . ' ' . $employeeData['lastName']; ?></h3>

    <table class="payroll-table">
        <thead>
            <tr>
                <th>EARNINGS</th>
                <th>AMOUNT</th>
                <th>DEDUCTIONS</th>
                <th>AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display Earnings (Salary and Overtime Pay)
            echo "<tr>
                    <td>Salary</td>
                    <td>₱" . number_format($totalSalary, 2) . "</td>
                    <td></td>
                    <td></td>
                  </tr>";
            
            echo "<tr>
                    <td>Overtime Pay</td>
                    <td>₱" . number_format($totalOvertimePay, 2) . "</td>
                    <td></td>
                    <td></td>
                  </tr>";

            // Display Deductions (Cash Advance and Adjustment)
            echo "<tr>
                    <td></td>
                    <td></td>
                    <td>Cash Advance</td>
                    <td>₱" . number_format($totalCashAdvance, 2) . "</td>
                  </tr>";
            
            echo "<tr>
                    <td></td>
                    <td></td>
                    <td>Adjustment</td>
                    <td>₱" . number_format($totalAdjustment, 2) . "</td>
                  </tr>";
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td>TOTAL EARNINGS:</td>
                <td>₱<?php echo number_format($totalEarnings, 2); ?></td>
                <td>TOTAL DEDUCTIONS:</td>
                <td>₱<?php echo number_format($totalDeductions, 2); ?></td>
            </tr>
            <tr>
                <td colspan="3">NET PAY:</td>
                <td>₱<?php echo number_format($netPay, 2); ?></td>
            </tr>
        </tfoot>
    </table>

        <div class="signatures">
            <div class="signature">
                <p>EMPLOYER SIGNATURE</p>
                <hr>
            </div>
            <div class="signature">
                <p>EMPLOYEE SIGNATURE</p>
                <hr>
            </div>
        </div>

        <button class="print-btn" onclick="printPayslip()">PRINT</button>
    </div>
</body>
</html>
