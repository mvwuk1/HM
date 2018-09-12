<?php
//Database connection information

$jsonFile = 'Q16_Aqua_NONDD.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);
$strQID = "Q16_Aqua_NONDD";
$strProj = "OP10565";
$lngRespondent = 0;
$lngInserts = 0;
$myfile = fopen("Q16_Aqua_NONDD.csv", "w") or die("Unable to open file!");
fwrite($myfile,"ProjID,ID,QID,BlnMobile,dtRow,dtCol,dtValue\n");
foreach ($jsonData as $key => $jsons) { // This will search in the 2 jsons
    foreach($jsons as $key => $value) {
        if($key == 'cid'){
            $currId = $value;
        }
        if($key == 'data'){
            if (sizeof($value) <> 0) {
                $lngRespondent++;
                if ($value[0]["parColumns"]== 41) {
                    $blnMobileScrn = 0;
                }
                else {
                    $blnMobileScrn = 1;
                }
                //$value[0]["parColumns"]
                //$value[0]["parRows"]
                for ($rowLoop = 1; $rowLoop <= $value[0]["parRows"]; $rowLoop++) {
                    for ($colLoop = 1; $colLoop <= $value[0]["parColumns"]; $colLoop++) {
                        $dataVal = $value[0]["Rows"][$rowLoop-1]["Cells"][$colLoop-1]["cellVal"];
                        $strCSV = "'$strProj','$currId','$strQID',$blnMobileScrn,$rowLoop,$colLoop,$dataVal\n";
                        fwrite($myfile, $strCSV);
                        $lngInserts++;
                    }
                }
                
                
            }
        }
   }
}
echo 'Respondents: ' . $lngRespondent;
echo 'Respondents: ' . $lngInserts;

?>