<?php
// Open the CSV file
function processCSVData($csvFilePath){
    $csvFile = fopen($csvFilePath, 'r');

    // Include the database connection
    require_once("includes/db.inc.php");
    
    // Flag to keep track if we're on the employee name row or the clock-in/out row
    $isFirstRow = true;
    $skipRow = false;
    $employeeName = ""; // Variable to store employee name
    
    try {
        // SQL query to insert attendance data
        $query = "
            INSERT INTO attendance (employeeID, clockInTime, clockOutTime) 
            VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
    
        // Read the CSV row by row
        while (($row = fgetcsv($csvFile)) !== false) {
            if ($isFirstRow) {
                $employeeName = $row[10]; // Assuming the employee name is in column 10 (index 9)
                
                // Skip rows where employee name is empty
                if (empty($employeeName)) {
                    $isFirstRow = false; // Skip the current row and go to the next one
                    $skipRow = true;
                    continue;
                }
    
                // Fetch the employee ID based on the employee name
                $employeeIDQuery = "SELECT employeeID FROM employee WHERE employeeCode = ?";
                $employeeStmt = $pdo->prepare($employeeIDQuery);
                $employeeStmt->execute([$employeeName]);
                $employee = $employeeStmt->fetch(PDO::FETCH_ASSOC);
    
                if ($employee) {
                    $employeeID = $employee['employeeID'];
                    echo "Employee Name: " . $employeeName . " | Employee ID: " . $employeeID . "<br>";
                } else {
                    echo "Employee not found: " . $employeeName . "<br>";
                    $skipRow = true; // Skip further processing for this employee
                }
    
                // Set the flag for the next row to handle clock-in and clock-out times
                $isFirstRow = false;
            } else {
                if (!$skipRow) {
                    // Loop through columns starting from index 2 (assuming dates start at column 2)
                    for ($colIndex = 2; $colIndex < count($row); $colIndex++) {
                        $timeString = $row[$colIndex]; // Clock-in/clock-out times for the day
                        
                        // Skip empty columns (no clock-in/clock-out data)
                        if (empty($timeString)) {
                            continue;
                        }
                        
                        // Split the time string by space to get individual times
                        $times = explode("\n", $timeString);
                        
                        // Check if there are at least two times (clock-in and clock-out)
                        $numTimes = count($times);
                        if ($numTimes >= 2) {
                            $clockInTime = $times[0];             // First time (clock-in)
                            $clockOutTime = $times[$numTimes - 2]; // Last time (clock-out)
                
                            // Calculate the date corresponding to the column
                            $dayOfMonth = $colIndex + 1; // Column 2 corresponds to December 1
                            $date = "2024-12-" . str_pad($dayOfMonth, 2, "0", STR_PAD_LEFT); // Format as YYYY-MM-DD
                
                            // Combine date with times to create full datetime strings
                            $clockInDateTime = $date . " " . $clockInTime . ":00";  // Append seconds as ":00"
                            $clockOutDateTime = $date . " " . $clockOutTime . ":00";
                
                            // Insert the data into the database
                            $stmt->execute([$employeeID, $clockInDateTime, $clockOutDateTime]);
                
                            // Display confirmation
                            echo "Inserted: Employee ID: $employeeID | Clock-in: $clockInDateTime | Clock-out: $clockOutDateTime<br>";
                        }
                    }
                }
                
                
                
    
                $skipRow = false;
                $isFirstRow = true;
            }
        }
    
        // Close the database connection
        $pdo = null;
        $stmt = null;
    
    } catch (PDOException $e) {
        // Handle errors
        die("Database error: " . $e->getMessage());
    }
    
    // Close the CSV file
    fclose($csvFile);
}

?>
