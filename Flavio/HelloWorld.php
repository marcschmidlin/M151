<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $vorname = "Übung macht den meister"; 
    $nachname = "Es ist noch kein meister vom Himmelrigefallen";
    $jahrgang = 2001; //Keine Anführungzeichen

    echo "Mein Name ist $vorname $nachname und ich bin im Jahr $jahrgang geboren <br>"; 

    $myArray = array( 
        $placeholder = "",
        $monat1 = "Januar",
        $monat2 = "Februar",
        $monat3 = "März",
        $monat4 = "April",
        $monat5 = "Mai",
        $monat6 = "Juni",
        $monat7 = "July",
        $monat8 = "August",
        $monat9 = "September",
        $monat10 = "Oktober",
        $monat11 = "November",
        $monat12 = "December",
    );
     
    //Aufgabe e
    print_r($myArray[date("n")]);

    //aufgabe d

    sort($myArray);

    foreach ($myArray as $value) {
        echo "$value <br>";
      }

    

    




    
    
    ?>
</body>
</html>