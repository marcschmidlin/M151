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
    //Aufgabe a
    echo "Übung macht den Meister <br> es ist noch kein Meister vom Himmel gefallen"; 
    //Aufgabe b
    $vornamen = "Marc";
    $nachnamen = "Schmidlin";
    $jahrgang = 1999; //Nummer ohne Anführungszeichen
    //Aufgabe c
    echo "<br>Mein Name ist $vornamen $nachnamen und ich bin $jahrgang geboren.";
    //Aufgabe d
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
     print_r($myArray);
    //Aufgabe e
    $aktuellermonat = date("n");
    print_r (array($aktuellermonat));
    ?>
    
</body>
</html>