<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
    <link rel="stylesheet" href="mainStyle.css">
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
        <div class="top-bar">
            <a href="addemployee.html"><button class="add-btn"> + ADD</button></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>POSITION</th>
                    <th>TEAM</th>
                    <th>RATE</th>
                    <th>CONTACT NUMBER</th>
                    <th>EMAIL</th>
                    <th>DATE HIRED</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Include database connection
                    require_once("../BACK END/includes/db.inc.php");
    
                    // SQL query to fetch employee data
                    $query = "SELECT employeeID, firstName, lastName, employeeType AS position, team, rate, contactNumber, email, dateHired FROM employee";
    
                    // Prepare and execute the query
                    $stmt = $pdo->query($query);
    
                    // Loop through the results and display each employee
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['firstName']) . " " . htmlspecialchars($row['lastName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['team']) . "</td>";
                        echo "<td>". htmlspecialchars($row["rate"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contactNumber']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['dateHired']) . "</td>";
                        echo "<td class='tools'>
                                <a href='editEmployee.php?employeeID=" . htmlspecialchars($row['employeeID']) . "'>
                                    <button class='edit'>Edit</button>
                                </a>
                              </td>";
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