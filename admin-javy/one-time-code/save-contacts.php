<?php

header("Content-Type: text/csv"); 
header("Content-Disposition: attachment; filename=file.csv");

function outputCSV($data) {
  $output = fopen("php://output", "wb");
  foreach ($data as $row)
    fputcsv($output, $row); // here you can change delimiter/enclosure
  fclose($output);
}

outputCSV(array(
  array("Test Contact", "0725622420"),
  array("Test Contact 2", "0736382902"),
  array("Test Contact 3", "0770237929")
));


?>