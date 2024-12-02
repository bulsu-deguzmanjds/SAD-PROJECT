<?php

// Include the Composer autoload file
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function convertExcelToCSV($inputFile, $outputFile) {
    $spreadsheet = IOFactory::load($inputFile);

    $sheet = $spreadsheet->getActiveSheet();

    $csvFile = fopen($outputFile, 'w');

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

    echo "Excel file has been converted to CSV successfully!";
}

$inputFile = '../new-payroll-sysmtem-2024.xlsx';
$outputFile = 'attendanceLog.csv'; 

convertExcelToCSV($inputFile, $outputFile);

?>
