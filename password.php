<?php 

$ref = "19-05-2018";
$datetime1 = new DateTime($ref);
$datetime2 = new DateTime();
$interval = $datetime1->diff($datetime2);
$days =  $interval->format('%a');
echo $days;
?>