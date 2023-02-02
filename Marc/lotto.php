<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Lottozahlen:</h1>
    <?php
    $lottozahlen = range(1, 42);
    $zusatzzahl = range(1, 6);
    shuffle($lottozahlen);
    shuffle($zusatzzahl);
    for($standardziehung = 1; $standardziehung <= 6; $standardziehung ++){
        echo "$lottozahlen[$standardziehung] <br>";}
    echo "$zusatzzahl[1]"
    ?>
</body>
</html>