<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Deduction</title>
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
            background-color: #aeaeae;
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
            margin-top: 15px;
        }
.sidebar h1   {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: white;   
        }
.sidebar h2 {
    margin-bottom: 30px;
    color:rgb(255, 255, 255);
}
.sidebar button:hover {
            background-color: #8e0000;
        }
        
        .form-container {
            flex: 1;
            padding: 20px;
        }

        .form-header {
           margin-bottom: 40px;
            width: 20%;
            display: flex;
            flex-direction: column;

        }

        .form-header h2 {
            font-size: 2.2rem;
            text-align: center;
        }

        .form-header .employee-id {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
    
        }

        .employee-id span {
            font-weight: bold;

        }

        .form-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-group {
            width: 30%;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .form-group input {
            padding: 8px;
            font-size: 0.9rem;
            border: 1px solid #000;
            border-radius: 4px;
        }

        .save-button {
            margin-top: 20px;
            text-align: right;
        }

        .save-button button {
            padding: 10px 20px;
            font-size: 1rem;
            color: #ffffff;
            background-color: #000;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        
        }

        .save-button button:hover {
            background-color: #f02727;
        }
    </style>
</head>
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

    <div class="form-container">
        <div class="form-header">
            <h2>ADD DEDUCTION</h2>
        </div>
        <!-- HTML Form with Dropdown -->
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
</form>
<BR></BR>
        <form action="deduction.php" method="post">
            <div class="form-content">
                <div class="form-group">
                    <label for="cashAdvance">Cash Advance</label>
                    <input type="text">
                </div>
                <div class="form-group">
                    <label for="adjustment">Adjustment</label>
                    <input type="text">
                </div>
            </div>
            <div class="save-button">
                <button type="submit">SAVE</button>
            </div>
        </form>


       
    </div>
</body>
</html>
