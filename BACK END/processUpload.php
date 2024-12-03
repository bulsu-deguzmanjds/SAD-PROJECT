<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['file']['tmp_name'];
        $originalFileName = $_FILES['file']['name'];
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        echo $extension;
        // Validate file extension
        if (in_array($extension, ['xls', 'xlsx', 'XLS', 'XLSX'])) {
            // Define paths for the converted CSV file
            $csvFileName = 'attendanceLog.csv'; // Define a consistent output file name
            $csvFilePath = __DIR__ . '/' . $csvFileName;

            // Include conversion script
            require_once('convertToCSV.php');

            // Convert the XLS/XLSX file to CSV
            convertExcelSheetToCSV($uploadedFile, $csvFilePath);

            // Include the script to process CSV data
            require_once('readCSVdata.php');

            // Process the converted CSV
            processCSVData($csvFilePath);

            echo "File uploaded, converted, and data inserted successfully!";

            header("Location: ../FRONT END/attendance.php");
        } else {
            echo "Invalid file type. Please upload an .xls or .xlsx file.";
        }
    } else {
        echo "File upload failed. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
