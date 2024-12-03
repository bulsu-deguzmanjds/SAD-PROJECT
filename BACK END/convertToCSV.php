<?php

// Include the Composer autoload file
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function convertSpecificExcelSheetToCSV($inputFile, $outputFile, $sheetNameOrIndex) {
    // Load the Excel file
    $spreadsheet = IOFactory::load($inputFile);

    // Select the specific sheet
    if (is_numeric($sheetNameOrIndex)) {
        // If the input is a number, treat it as the sheet index (0-based)
        $sheet = $spreadsheet->getSheet($sheetNameOrIndex);
    } else {
        // If the input is a string, treat it as the sheet name
        $sheet = $spreadsheet->getSheetByName($sheetNameOrIndex);
    }

    if (!$sheet) {
        throw new Exception("Sheet not found: $sheetNameOrIndex");
    }

    // Open the CSV file for writing
    $csvFile = fopen($outputFile, 'w');

    // Loop through rows in the selected sheet and write to CSV
    foreach ($sheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); 
        $rowData = [];
        foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getFormattedValue();
        }

        fputcsv($csvFile, $rowData);
    }

    // Close the CSV file
    fclose($csvFile);

    echo "Excel sheet has been converted to CSV successfully!";
}

$inputFile = '12MON.xls';
$outputFile = 'attendanceLog.csv'; 
$sheetNameOrIndex = 2; // Use 0 for the first sheet, or replace with the desired sheet name

try {
    convertSpecificExcelSheetToCSV($inputFile, $outputFile, $sheetNameOrIndex);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
