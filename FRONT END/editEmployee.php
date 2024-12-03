<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>        * {
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
        font-size: 1.2rem;
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
    }</style>
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

    <div class="form-container">
        <div class="form-header">
            <h2>EDIT EMPLOYEE</h2>
        </div>
        <form action="../BACK END/includes/editEmployee.inc.php" method="post">
        <?php
        // Include database connection
        require_once("../BACK END/includes/db.inc.php");

        // Check if an employeeID is provided in the URL or form submission
        if (isset($_GET['employeeID'])) {
            $employeeID = $_GET['employeeID'];

            try {
                // Fetch employee data
                $query = "SELECT * FROM employee WHERE employeeID = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$employeeID]);
                $employee = $stmt->fetch(PDO::FETCH_ASSOC);

                // Check if employee exists
                if (!$employee) {
                    die("Error: Employee not found.");
                }
            } catch (PDOException $e) {
                die("Error retrieving employee data: " . $e->getMessage());
            }
        } else {
            die("Error: No employee ID provided.");
        }
        ?>
            <div class="form-content">
                <input type="hidden" name="employeeID" value="<?php echo $employee['employeeID']; ?>">

                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="firstName" value="<?php echo htmlspecialchars($employee['firstName']); ?>">
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="lastName" value="<?php echo htmlspecialchars($employee['lastName']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>">
                </div>
                <div class="form-group">
                    <label for="contact-number">Contact Number</label>
                    <input type="text" id="contact-number" name="contactNumber" value="<?php echo htmlspecialchars($employee['contactNumber']); ?>">
                </div>
                <div class="form-group">
                    <label for="team">Team</label>
                    <select id="team" name="team">
                        <?php
                        // Predefined teams
                        $teams = ["Calumpit", "Hagonoy", "Marilao", "Malolos", "Pitpitan", "SmartVille"];
                        $currentTeam = $employee['team']; // Assume this holds the current team value

                        // Generate options
                        foreach ($teams as $team) {
                            $selected = ($team === $currentTeam) ? "selected" : "";
                            echo "<option value='" . htmlspecialchars($team) . "' $selected>" . htmlspecialchars($team) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="employee-type">Employee Type</label>
                    <input type="text" id="employee-type" name="employeeType" value="<?php echo htmlspecialchars($employee['employeeType']); ?>">
                </div>
                <div class="form-group">
                    <label for="rate">Rate</label>
                    <input type="text" id="rate" name="rate" value="<?php echo htmlspecialchars($employee['rate']); ?>">
                </div>
                <div class="form-group">
                    <label for="date-hired">Date Hired</label>
                    <input type="date" id="date-hired" name="dateHired" value="<?php echo htmlspecialchars($employee['dateHired']); ?>">
                </div>
                <div class="form-group">
                    <label for="employeeCode">Employee Code</label>
                    <input type="text" id="employeeCode" name="employeeCode" value="<?php echo htmlspecialchars($employee['employeeCode']); ?>">
                </div>
            </div>
            <div class="save-button">
                <button type="submit">SAVE</button>
            </div>
        </form>
    </div>
</body>
</html>
