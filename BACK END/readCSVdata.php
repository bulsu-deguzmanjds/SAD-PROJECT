<?php
// Open the CSV file
$csvFile = fopen('attendanceLog.csv', 'r');

// Flag to keep track if we're on the employee name row or the clock-in/out row
$isFirstRow = true;
$skipRow = false;
$employeeName = ""; // Variable to store employee name

// Read the CSV row by row
while (($row = fgetcsv($csvFile)) !== false) {
    // Check if the employee name (column 10) is empty
    if ($isFirstRow) {
        $employeeName = $row[10]; // Assuming the employee name is in column 10 (index 9)
        
        // Skip rows where employee name is empty
        if (empty($employeeName)) {
            $isFirstRow = false; // Skip the current row and go to the next one
            $skipRow = true;
            continue;
        }

        // Display the employee name
        echo "Employee Name: " . $employeeName . "<br>";

        // Set the flag for the next row to handle clock-in and clock-out times
        $isFirstRow = false;
    } else {
        if (!$skipRow) {
            $timeString = $row[2]; // Clock-in/clock-out times in the form "15:03 15:03 15:14 15:14"
        
            // Split the time string by space to get individual times
            $times = explode("\n", $timeString);
        
            // Loop through the array and process pairs of clock-in and clock-out times
            $numTimes = count($times);
            
            // Ensure there is at least one pair (clock-in, clock-out)
            if ($numTimes >= 2) {
                for ($i = 0; $i < $numTimes - 1; $i += 2) {
                    $clockIn = $times[$i];    // Clock-in time
                    $clockOut = $times[$i + 1]; // Clock-out time
                    
                    // Display clock-in and clock-out times
                    echo " | Clock-in: " . $clockIn . " | Clock-out: " . $clockOut . "<br>";
                }
            }
        }

        $skipRow=false;
        $isFirstRow = true;
    }
}

// Close the CSV file
fclose($csvFile);
?>
