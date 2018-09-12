<?php
//Database connection information
$host="vwrs.net"; // Host name 
$username="vwrsnet_HM"; // Mysql username 
$password="CheeseCake101"; // Mysql password 
$db_name="vwrsnet_HM"; // Database name  
$tbl_name="tblUsers"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("Cannot connect to server"); 
mysql_select_db("$db_name")or die("Cannot select database");	

$jsonFile = 'Q16_Aqua_DD.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);
$strQID = "Q16_Aqua_DD";
$strProj = "OP10565";
$lngRespondent = 0;
$lngInserts = 0;
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
                        $strSQL = "INSERT INTO vwrsnet_HM.tblHeatMapData 
                        (ProjID, 
                        ID, 
                        QID, 
                        blnMobile, 
                        dtRow, 
                        dtColumn,
                        dtValue) 
                        VALUES 
                        ('$strProj' , 
                        '$currId', 
                        '$strQID', 
                        $blnMobileScrn, 
                        $rowLoop, 
                        $colLoop,
                        $dataVal);";
                        mysql_query($strSQL);
                        
                        $lngInserts++;
                    }
                }
                
                
            }
        }
   }
}
echo 'Respondents: ' . $lngRespondent;
echo 'Inserts: ' . $lngInserts;
?>