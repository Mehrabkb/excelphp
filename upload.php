<?php 
if ($_FILES['csv']['error'] == 0 && pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION) === 'csv') {
    $tmpName = $_FILES['csv']['tmp_name'];
    $totalArr = [];
    if (($handle = fopen($tmpName, 'r')) !== FALSE) {
        $fArray = [];
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Process each row of data here
            if(isset($_POST['objectiv'])){
                $obj = htmlspecialchars($_POST['objectiv']);
                array_push($totalArr , $data[58]);
                // print_r($data[8]);
                // echo '<br>';
            }
            $finalArr = totalArrClear($totalArr , $obj);
            // print_r($finalArr);
            for($i = 0 ; $i < count($finalArr) ; $i++){
                $data[8] = $finalArr[$i];
            }
            array_push($fArray , $data);
        }
        // print_r($fArray);
        putDataInCsvFile($fArray);

        fclose($handle);
    }
    $totalArr[0] = 'توضیحات';
    // print_r($totalArr);
}
function totalArrClear($arr , $obj){
    $arr[0] = 'توضیحات';
    for($i = 1 ; $i < count($arr) ; $i++){
        $arr[$i] = 'سایز:' . $arr[$i] . $obj;
    }
    return $arr;
}
function putDataInCsvFile($data){
    $filename = 'test.csv';
    // Open CSV file for writing
    $f = fopen($filename, 'w');

    if ($f === false) {
        die('Error opening the file ' . $filename);
    }
    // Write each row at a time to a file
    foreach ($data as $row) {
        fputcsv($f, $row);
    }
    // Close the file
    fclose($f);
    echo '<a href="test.csv">فایل</a>';
}