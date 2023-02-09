<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swisslos</title>
</head>
<body>
<h1>Lottozahlen</h1>
<?php

$lottozahlen = array();
$zuasatzzahl = rand(1, 6);

for ($i = 1; $i <= 6; $i++) {
    do{
        $neuezahl= rand(1, 42);
    }while(in_array($neuezahl, $lottozahlen));{
    $lottozahlen[]=$neuezahl;
    }
    }
    sort($lottozahlen);
    print_r($lottozahlen);












?>
    
</body>
</html>