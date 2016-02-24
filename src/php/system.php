<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2/18/2016
 * Time: 6:05 PM
 */
include ("include.php");
header('Content-Type: application/json');
$systemID = 0;
$systemName = "";
$system = false;

//Get Solar System
if(isset($_GET['ID'])) {
    $systemID = $_GET['ID'];
    $system = $db->selectWhere("mapsolarsystems", ['solarSystemID' => $systemID],[
        'solarSystemID',
        'solarSystemName',
        'x','y','z',
        'xMin','yMin','zMin',
        'xMax','yMax','zMax',
        'luminosity',
        'security',
        'factionID',
        'sunTypeID',
        'securityClass'
    ]);

}elseif(isset($_GET['NAME'])) {
    $systemName = $_GET['NAME'];
    $system = $db->selectWhere("mapsolarsystems", ['solarSystemName' => $systemName]);
}
if(!$system || $system->rows == 0 ){
    trigger_error("System Not Found");
    die();
}else{
    $system = $system->results[0];
}


//Get celestials
$celestials = $db->selectWhere("mapdenormalize", ['solarSystemID' => $system['solarSystemID']]);
$system['celestials']= $celestials->results;
foreach($system['celestials'] as $i=>$celestial){
    $typeInfo =$db->selectWhere("invtypes", ['typeID' => $celestial['typeID']]);
    $system['celestials'][$i]['type'] = [];
    //get this type info if it exist
    if($typeInfo && $typeInfo->rows > 0) {
        $typeInfo = crest::getType($celestial['typeID']);
        if(isset($typeInfo['graphicID']))
            $typeInfo['graphic'] = crest::getGraphic($typeInfo['graphicID']);
        $system['celestials'][$i]['type'] = $typeInfo;
    }
}
die(json_encode($system));

