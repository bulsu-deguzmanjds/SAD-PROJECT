<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Dashboard</title>
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

        .header-title {
            text-align: left;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #3d3c3c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        table th, table td {
            border: 1px solid #747373;
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

        .upload {
            padding-top: 10px;
        }
 
        #submit {
            background-color: #2cbe21;
            padding: 10px 20px;
            border-radius:15%;
            border: none;
            color: white;
        }
    </style>
</head> 
<body>
    <div class="sidebar">
        <h1>VILLAFUERTE</h1>
        <h2>DESIGN-BUILDERS</h2>
        <a href="dashboardPage.html"><button class="add-btn"> DASHBOARD</button></a>
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
    </script>

    <div class="main-content">
        <?php
        try {
            require_once("../BACK END/includes/db.inc.php");

            // Fetch employee data
            $query = "SELECT employeeID, firstName, lastName FROM employee";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $attendanceRecords = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employeeID'])) {
                $selectedEmployeeID = $_POST['employeeID'];

                // Fetch attendance records for the selected employee
                $attendanceQuery = "SELECT a.attendanceID, a.clockInTime, a.clockOutTime, TIMESTAMPDIFF(HOUR, a.clockInTime, a.clockOutTime) AS hoursWorked
                                    FROM attendance a
                                    WHERE a.employeeID = ?";
                $stmt = $pdo->prepare($attendanceQuery);
                $stmt->execute([$selectedEmployeeID]);
                $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
        ?>

        <!-- HTML Form with Dropdown -->
        <form action="" method="post">
            <label for="employee">Select Employee:</label>
            <select name="employeeID" id="employee">
                <option value="" disabled selected>-- Select an Employee --</option>
                <?php foreach ($employees as $employee): ?>
                    <option value="<?= htmlspecialchars($employee['employeeID']) ?>">
                        <?= htmlspecialchars($employee['firstName'] . ' ' . $employee['lastName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button id="submit" type="submit">Submit</button>   
        </form>

        <form class="upload" action="../BACK END/processUpload.php" method="post" enctype="multipart/form-data">
            <input type="file" id="myFile" name="file" accept=".xls, .xlsx" required>
            <input id="submit" type="submit" value="Upload">
        </form>

        <div class="header-title">ATTENDANCE</div>

        <table>
        <thead>
            <tr>
                <th>ATTENDANCE ID</th>
                <th>CLOCK IN TIME</th>
                <th>CLOCK OUT TIME</th> 
                <th>HOURS WORKED</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attendanceRecords as $record): ?>
                <tr>
                    <td><?= htmlspecialchars($record['attendanceID']) ?></td>
                    <td><?= htmlspecialchars($record['clockInTime']) ?></td>
                    <td><?= htmlspecialchars($record['clockOutTime']) ?></td>
                    <td><?= htmlspecialchars($record['hoursWorked']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>
</html>