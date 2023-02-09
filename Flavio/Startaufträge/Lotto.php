<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
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

        foreach($lottozahlen as $value){
            echo "<div><h5>".$value."</h5></div>";
        }

        echo "<div><h4>".$zuasatzzahl."</h4></div>";
        

?>

<form method="post">
<input type="submit" value="submit" name="Submit">
</form>
    
</body>
</html>