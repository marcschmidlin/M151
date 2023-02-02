<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleLotto.css">
    <title>Lottozahlen</title>
</head>
<body>
    <h1>Lottozahlen:</h1>
    <?php
    $lottozahlen = range(1, 42);
    $zusatzzahl = range(1, 6);
    shuffle($lottozahlen);
    shuffle($zusatzzahl);
    for ($i = 7; $i <= 42; $i++)  
    unset($lottozahlen[$i]);
    sort($lottozahlen);
    //for($standardziehung = 1; $standardziehung <= 6; $standardziehung ++){
         //echo "$lottozahlen[$standardziehung] <br>";
    //}
    
    ?>
   
   <div id="boxNormal"><p><?php echo "$lottozahlen[1]";?></p></div> 
   <div id="boxNormal"><p><?php echo "$lottozahlen[2]";?></p></div> 
   <div id="boxNormal"><p><?php echo "$lottozahlen[3]";?></p></div> 
   <div id="boxNormal"><p><?php echo "$lottozahlen[4]";?></p></div> 
   <div id="boxNormal"><p><?php echo "$lottozahlen[5]";?></p></div>
   <div id="boxNormal"><p><?php echo "$lottozahlen[6]";?></p></div>
   <div id="boxZusatz"><p><?php echo "$zusatzzahl[1]";?></p></div>
   <div class="clear"><a href="<?php $_SERVER['PHP_SELF']; ?>" class="myButton">Neue Zahlen</a></div>
</body>
</html>