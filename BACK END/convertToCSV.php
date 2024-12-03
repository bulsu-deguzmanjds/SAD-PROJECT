<?php
// Include the Composer autoload file
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function convertExcelSheetToCSV($inputFile, $outputFile) {
    // Load the Excel file
    $spreadsheet = IOFactory::load($inputFile);


        $sheet = $spreadsheet->getSheet(0);

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

?>
