<?php

function processGrossSalary() {
    
    try {
        require("includes/db.inc.php");
        $pdo->exec("TRUNCATE TABLE grossSalary");
        // Fetch all employees and their rates from the employee table
        $employeeQuery = "SELECT employeeID, rate FROM employee";
        $employeeStmt = $pdo->prepare($employeeQuery);
        $employeeStmt->execute();

        $employees = $employeeStmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($employees)) {
            echo "No employees found for salary processing.<br>";
            return;
        }

        foreach ($employees as $employee) {
            $employeeID = $employee['employeeID'];
            $rate = $employee['rate'];

            $daysPresent = calculateDaysPresent($employeeID, $pdo); 
            $overtimeHours = calculateOvertimeHours($employeeID, $pdo); 

            $overtimeRate = $rate / 8;

            $overtimePay = $overtimeHours * $overtimeRate;
            $salary = ($daysPresent * $rate) + $overtimePay;

            $grossSalaryQuery = "
                INSERT INTO grossSalary (employeeID, daysPresent, overtimeHours, overtimePay, salary)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    daysPresent = VALUES(daysPresent),
                    overtimeHours = VALUES(overtimeHours),
                    overtimePay = VALUES(overtimePay),
                    salary = VALUES(salary)";
            $grossSalaryStmt = $pdo->prepare($grossSalaryQuery);

            $grossSalaryStmt->execute([$employeeID, $daysPresent, $overtimeHours, $overtimePay, $salary]);

            echo "Processed gross salary for Employee ID: $employeeID<br>";
        }
    } catch (PDOException $e) {
        echo "Error processing gross salaries: " . $e->getMessage();
    }
}
function calculateDaysPresent($employeeID, $pdo) {
    try {
        $query = "SELECT COUNT(DISTINCT DATE(clockInTime)) as daysPresent 
                  FROM attendance WHERE employeeID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$employeeID]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Error calculating days present for Employee ID: $employeeID: " . $e->getMessage();
        return 0;
    }
}
function calculateOvertimeHours($employeeID, $pdo) {
    try {
        $query = "SELECT SUM(TIMESTAMPDIFF(HOUR, clockInTime, clockOutTime) - 8) as overtimeHours 
                  FROM attendance WHERE employeeID = ? AND TIMESTAMPDIFF(HOUR, clockInTime, clockOutTime) > 8";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$employeeID]);
        return max(0, $stmt->fetchColumn());
    } catch (PDOException $e) {
        echo "Error calculating overtime hours for Employee ID: $employeeID: " . $e->getMessage();
        return 0;
    }
}

?>