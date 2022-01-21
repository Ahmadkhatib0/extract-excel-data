<?php
include "vendor/autoload.php";

$connect = new PDO("mysql:host=localhost;dbname=extract_excel_data", "Ahmad", "12345678");

if ($_Files["import_excel"]['name'] != "") {
    $allowed_extension = array('xls', 'csv', 'xlsx');
    $inputted_file = explode(".", $_Files['import_excel']['name']);
    $file_extension = end($inputted_file); //last index from an array

    if (in_array($file_extension, $allowed_extension)) {
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify
            ($_Files["import_excel"]['name']);
        $reader = \PhpOffice\PHPSpreadsheet\IOFactory::createReader($file_type);
        $spreadsheet = $reader->load($_Files["import_excel"]['name']);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $row) {
            $insert_data = array(
                ":registrationNr" => $row[0],
                ":companyName" => $row[1],
                ":sectorCalssificationCode" => $row[2],
                ":sectorCalssification" => $row[3],
                ":sectorCommitteeCode" => $row[4],
                ":sectorCommittee" => $row[5],
                ":nace" => $row[6],
                ":productionField" => $row[7],
                ":registrationDate" => $row[8],
                ":address" => $row[9],
                ":city" => $row[10],
                ":district" => $row[11],
                ":region" => $row[12],
                ":postalCode" => $row[13],
                ":phone1" => $row[14],
                ":phone2" => $row[15],
                ":phone3" => $row[16],
                ":fax1" => $row[17],
                ":fax2" => $row[18],
                ":email" => $row[19],
                ":webAddress" => $row[20],
            );
            $query = "
            INSERT INTO companies
            (registrationNr , companyName , sectorCalssificationCode , sectorCalssification , sectorCommitteeCode
            , sectorCommittee , nace , productionField , registrationDate , address , city , district ,
             region , postalCode , phone1 , phone2 , phone3 ,fax1 ,
             fax2 , email , webAddress )";
            $statement = $connect->prepare($query);
            $statement->execute($insert_data);
        }
        $message = '<div class="alert alert-success">Data Imported Successfully</div>';
    } else {
        $message = '<div class="alert alert-danger">Only .xls or .xlsx file allowed</div>';
    }
} else {
    $message = "<div class='alert alert-danger'> Please select a file first </div>";
}

echo $message;
