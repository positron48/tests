<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Туда-сюда</title>
</head>
<body>
<h1>Туда-сюда</h1>
<?php
class AirportStructure{
    public $id;
    public $timeZoneDepart;
    public $dateOfDepart;
    public $timeZoneArrive;
    public $dateOfArrive;

}
readTests();
function readTests(){
    $directory = './tests/';
    $fileList = array_diff(scandir($directory), array('.', '..'));
    //print_r($fileList);
    $tests = Array();
    $testCounter = 1;
    $flight = null;

    global $argv;
    $handle = fopen($argv[1],"r");

    $numberOfFlights = fgets($handle);
    for($i=0;$i<$numberOfFlights;$i++){
        $flight = new AirportStructure();
        $flight->id=$testCounter;
        $tempString = fgets($handle);
        $arrayOfInputVars = explode(' ',$tempString);
        if(checkDateTime($arrayOfInputVars[0])!==null){
            $flight->dateOfDepart = checkDateTime($arrayOfInputVars[0]);
            $flight->timeZoneDepart = $arrayOfInputVars[1];
        }
        if(checkDateTime($arrayOfInputVars[2])!==null){
            $flight->dateOfArrive = checkDateTime($arrayOfInputVars[2]);
            $flight->timeZoneArrive = $arrayOfInputVars[3];
        }
        $testCounter++;
        $tests[] = $flight;
    }

    //print_r("here");
    $results = Array();
    $fp = fopen($argv[2],"w");
    $id=0;
    $resultString = "";
    foreach($tests as $flight){
        $results[] = getSeconds($flight);
        $resultString.=$results[$id].PHP_EOL;
        $id++;
    }
    fwrite($fp,$resultString);
    fclose($fp);

}

function getSeconds($flight){
    $dateTimeOfDepart = $flight->dateOfDepart;
    $dateTimeOfArrive = $flight->dateOfArrive;
    $timeZoneDepart = str_replace("\n","",$flight->timeZoneDepart);
    $timeZoneArrive = str_replace("\n","",$flight->timeZoneArrive);
    if($timeZoneDepart<0){
        $timeZoneDepart*=-1;
        $dateIntervalStringDepart = 'PT'.$timeZoneDepart.'H';
        $dateTimeOfDepart->add(new DateInterval($dateIntervalStringDepart));
    }
    else{
        $dateIntervalStringDepart = 'PT'.$timeZoneDepart.'H';
        $dateTimeOfDepart->sub(new DateInterval($dateIntervalStringDepart));
    }
    if($timeZoneArrive<0){
        $timeZoneArrive*=-1;
        $dateIntervalStringArrive = 'PT'.$timeZoneArrive.'H';
        $dateTimeOfArrive->add(new DateInterval($dateIntervalStringArrive));
    }
    else{
        $dateIntervalStringArrive = 'PT'.$timeZoneArrive.'H';
        $dateTimeOfArrive->sub(new DateInterval($dateIntervalStringArrive));
    }
    return (strtotime(date_format($dateTimeOfArrive,'d.m.Y H:i:s'))-strtotime(date_format($dateTimeOfDepart,'d.m.Y H:i:s')));
}
function checkDateTime($date){

    $tempDate = explode('_',$date);
    $currentDate = $tempDate[0]." ".$tempDate[1];
    if(DateTime::createFromFormat('d.m.Y H:i:s', $currentDate) != false){
        return DateTime::createFromFormat('d.m.Y H:i:s', $currentDate);
    }
    else{
        return null;
    }
}


?>
</body>
</html>

