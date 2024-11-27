<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
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

        
        .sidebar select:hover {
            background-color: #004080;
            color: white; 
        }
       
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-top: 20px;
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

        .add-btn {
            padding: 10px 20px;
            background-color: #007506;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-btn:hover {
            background-color: #000000;
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
        <a href="attendance.html"><button>ATTENDANCE</button></a>
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
            <a href="addemployee.html"><button class="add-btn"> + ADD</button></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>POSITION</th>
                    <th>TEAM</th>
                    <th>CONTACT NUMBER</th>
                    <th>EMAIL</th>
                    <th>DATE HIRED</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Include database connection
                    require_once("../BACK END/includes/db.inc.php");
    
                    // SQL query to fetch employee data
                    $query = "SELECT firstName, lastName, employeeType AS position, team, contactNumber, email, dateHired FROM employee";
    
                    // Prepare and execute the query
                    $stmt = $pdo->query($query);
    
                    // Loop through the results and display each employee
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['firstName']) . " " . htmlspecialchars($row['lastName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['team']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contactNumber']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['dateHired']) . "</td>";
                        echo "</tr>";
                    }
    
                    // Clean up
                    $pdo = null;
                    $stmt = null;
    
                } catch (PDOException $e) {
                    die("Error fetching employee data: " . $e->getMessage());
                }
                ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>