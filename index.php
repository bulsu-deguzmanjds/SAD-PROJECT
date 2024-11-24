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
        <input type="text" name="userID" placeholder="User ID"> 
        <input type="text" name="advance" placeholder="Cash Advance"> 
        <input type="text" name="kaltas" placeholder="Kaltas"> 
        <input type="text" name="adjustment" placeholder="Adjustment"> 
        <input type="text" name="gadget" placeholder="Gadget"> 
        <button>Add Deduction</button>
    </form>
    <br><br><br>
    <form action="includes/addGrossSalary.inc.php" method="post">
        <input type="text" name="userID" placeholder="User ID" required>
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
        <input type="text" name="userID" placeholder="User ID" required>
        <input type="datetime-local" name="clockInTime" placeholder="Clock In Time" required>
        <input type="datetime-local" name="clockOutTime" placeholder="Clock Out Time" required>
        <button>Submit Attendance</button>
    </form>


</body>
</html>