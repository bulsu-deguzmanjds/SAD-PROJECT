<?php

// Include the Composer autoload file
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function convertExcelToCSV($inputFile, $outputFile) {
    // Load the Excel file
    $spreadsheet = IOFactory::load($inputFile);

    // Get the active sheet
    $sheet = $spreadsheet->getActiveSheet();

    // Open the CSV file for writing
    $csvFile = fopen($outputFile, 'w');

    // Loop through each row of the spreadsheet
    foreach ($sheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Iterate all cells, even empty ones

        $rowData = [];
        foreach ($cellIterator as $cell) {
            // Add cell value to row data
            $rowData[] = $cell->getFormattedValue();
        }

        // Write the row data to the CSV file
        fputcsv($csvFile, $rowData);
    }

    // Close the CSV file
    fclose($csvFile);

    echo "Excel file has been converted to CSV successfully!";
}

// Define the input Excel file and output CSV file paths
$inputFile = 'path_to_your_excel_file.xlsx'; // Replace with the path to your Excel file
$outputFile = 'output_file.csv'; // Path for the C

convertExcelToCSV($inputFile, $outputFile);

?>
