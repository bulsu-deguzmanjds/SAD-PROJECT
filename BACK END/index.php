<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="includes/register.inc.php" method="post"> 
        <input type="text" name="fullname" placeholder="Full Name"> 
        <input type="password" name="pwd" placeholder="Password"> 
        <input type="text" name="email" placeholder="E-Mail"> 
        <button>Signup</button>
    </form>
    <br><br><br>
    <form action="includes/addDeductions.inc.php" method="post"> 
        <input type="text" name="employeeID" placeholder="Employee ID"> 
        <input type="text" name="advance" placeholder="Cash Advance"> 
        <input type="text" name="adjustment" placeholder="Adjustment"> 
        <button>Add Deduction</button>
    </form>
    <br><br><br>
    <form action="includes/addGrossSalary.inc.php" method="post">
        <input type="text" name="employeeID" placeholder="Employee ID" required>
        <input type="text" name="daysPresent" placeholder="Days Present" required>
        <input type="text" name="rate" placeholder="Rate" required>
        <input type="text" name="overtimeHours" placeholder="Overtime Hours" required>
        <input type="text" name="overtimePay" placeholder="Overtime Pay" required>
        <input type="text" name="salary" placeholder="Salary" required>
        <input type="text" name="adjustment" placeholder="Adjustment" required>
        <button>Submit Salary</button>
    </form>
    <br><br><br>
    <form action="includes/addAttendance.inc.php" method="post">
        <input type="text" name="employeeID" placeholder="Employee ID" required>
        <input type="datetime-local" name="clockInTime" placeholder="Clock In Time" required>
        <input type="datetime-local" name="clockOutTime" placeholder="Clock Out Time" required>
        <button>Submit Attendance</button>
    </form>
    <br><br><br>
    <form action="includes/addUser.inc.php" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="fullName" placeholder="Full Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Add User</button>
    </form>
    <br><br><br>
    <form action="includes/changePassword.inc.php" method="post">
        <input type="text" name="userID" placeholder="User ID" required>
        <input type="password" name="currentPassword" placeholder="Current Password" required>
        <input type="password" name="newPassword" placeholder="New Password" required>
        <button>Change Password</button>
    </form>
    <br><br><br>    
    <form action="includes/addEmployee.inc.php" method="post">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="contactNumber" placeholder="Contact Number" required>
        <input type="text" name="team" placeholder="Team" required>
        <input type="text" name="employeeType" placeholder="Employee Type (e.g., Full-time, Part-time)" required>
        <input type="date" name="dateHired" placeholder="Date Hired" required>
        <button type="submit">Add Employee</button>
    </form>
</body>
</html>