<?php
// Datenbankverbindung
include('./database/db_connector.inc.php');

// TODO - Session starten
session_start();
// variablen initialisieren
$error = $message = '';
$gewicht = $datumgewicht =  '';
if (!isset($_SESSION['loggedin']) && !$_SESSION['loggedin']) {
  header("Location: login/signin.php");
} else {
  // Session nicht OK,  Weiterleitung auf Anmeldung
  //  Script beenden// TODO -  Wenn personalisierte Session: Begrüssen des Benutzers mit Benutzernamen
  $email =  $_SESSION['email'];
  $message .= "Hallo $email";
}


if (empty($error)) {
  // Query erstellen
  $query = "SELECT * from benutzer where email =?";

  // Query vorbereiten
  $stmt = $mysqli->prepare($query);
  if ($stmt === false) {
    $error .= 'prepare() failed ' . $mysqli->error . '<br />';
  }
  // Parameter an Query binden
  if (!$stmt->bind_param("s", $email)) {
    $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
  }
  // Query ausführen
  if (!$stmt->execute()) {
    $error .= 'execute() failed ' . $mysqli->error . '<br />';
  }
  // Daten auslesen
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {

    $idBenutzer = $row['idBenutzer'];
    $vorname = $row['Vorname'];
    $nachname = $row['Name'];
    $email = $row['email'];
    $alter = $row['Alter'];
  }
  $result->free();
}












// Abfrage ausführen, wenn keine Fehler vorhanden sind
if (empty($error)) {
  // Query vorbereiten
  $query = "SELECT * FROM Gewicht";
  $stmt = $mysqli->prepare($query);
  if (!$stmt) {
    $error .= "Query-Vorbereitung fehlgeschlagen: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  // Query ausführen und Daten auslesen
  if (!$stmt->execute()) {
    $error .= "Query-Ausführung fehlgeschlagen: (" . $stmt->errno . ") " . $stmt->error;
  } else {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      // Datenverarbeitung hier


    }
    $result->free();
  }

  // Statement schließen
  $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // Uebungsname ausgefüllt?
  if (isset($_POST['gewicht'])) {
    //trim and sanitize
    $gewicht = htmlspecialchars(trim($_POST['gewicht']));


    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($gewicht) || strlen($gewicht) > 30) {
      $error .= "Geben Sie ein korrektes gewicht an.<br />";
    }
  } else {
    $error .= "Geben Sie bitte Gewicht ein.<br />";
  }

  // datum ausgefüllt?
  if (isset($_POST['datumgewicht'])) {
    //trim and sanitize
    $datumgewicht = htmlspecialchars(trim($_POST['datumgewicht']));


    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($datumgewicht) || strlen($datumgewicht) > 30) {
      $error .= "Geben Sie bitte einen korrektes gewicht ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Gewichtsdatum ein.<br />";
  }


  $query = "Insert into gewicht (Benutzer_idBenutzer, Datum, Gewicht) values (?, ?,?)";



  // Query vorbereiten
  $stmt = $mysqli->prepare($query);
  if ($stmt === false) {
    $error .= 'prepare() failed ' . $mysqli->error . '<br />';
  }

  // Parameter an Query binden
  if (!$stmt->bind_param('sss', $idBenutzer, $datumgewicht, $gewicht)) {
    $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
  }

  // Query ausführen
  if (!$stmt->execute()) {
    $error .= 'execute() failed ' . $mysqli->error . '<br />';
  }

  // kein Fehler!
  if (empty($error)) {
    $message .= "Die Daten wurden erfolgreich in die Datenbank geschrieben<br/ >";
    // Felder leeren und Weiterleitung auf anderes Script: z.B. Login!
    // Verbindung schliessen

    // Weiterleiten auf login.php

    // beenden des Scriptes

  }
}



?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <title>Inner Page - Gp Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CRaleway:300,300i,400,400i,500,500i,600,600i,700,700i%7CPoppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Gp
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>




<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-inner-pages">
    <div class="container d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="index.html">FM Fitness<span>.</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto " href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="./account.php" class="get-started-btn scrollto">Logged In <?php echo $vorname ?></a>

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Gewichtstracking</h2>
          <ol>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./inner-page.php">Übersicht</a></li>
            <li>Gewichtstracking</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <h2>
          Willkommen Zurück <?php echo $vorname ?>
        </h2>
        <h3>Tracke dein Gewicht</h3>
      </div>
    </section>



    <form  method="post">

      <h2>Gewicht hinzufügen</h2>


      <!-- Datum -->

      <div class="form-group">
        <label for="datumgewicht">Datum:</label>
        <input type="date" id="datumgewicht" name="datumgewicht"  required>
      </div>

      <!-- Gewicht -->
      <div class="form-group">
        <label for="gewicht">Gewicht:</label>
        <input type="number" id="gewicht" name="gewicht" placeholder="Geben Sie das Gewicht an.">
      </div>

      <button type="submit" name="button" value="submit" class="btn btn-info">Gewicht Speichern</button>




    </form>
    </div>

    <h2>Eingetragene Gewichte</h2>
    <style>
      ul.gewicht-liste {
        list-style-type: none;
        margin: 0;
        padding: 0;
      }

      ul.gewicht-liste li {
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        background-color: #f7f7f7;
        color: #333;
        font-size: 16px;
        font-family: Arial, sans-serif;
      }

      ul.gewicht-liste li:hover {
        background-color: #eaeaea;
      }
    </style>



    <!-- Zuerst benötigen wir die Google Charts API -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <?php
    // Erstellen der Abfrage und Ausführen, um die Daten aus der Datenbank zu erhalten
    if (empty($error)) {
      // Query erstellen
      $query = "SELECT * from gewicht where Benutzer_idBenutzer =?";

      // Query vorbereiten
      $stmt = $mysqli->prepare($query);
      if ($stmt === false) {
        $error .= 'prepare() failed ' . $mysqli->error . '<br />';
      }
      // Parameter an Query binden
      if (!$stmt->bind_param("s", $idBenutzer)) {
        $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
      }
      // Query ausführen
      if (!$stmt->execute()) {
        $error .= 'execute() failed ' . $mysqli->error . '<br />';
      }
      // Daten auslesen
      $result = $stmt->get_result();

      // Die Daten in ein Array speichern
      $data = array();
      while ($row = $result->fetch_assoc()) {
        $gewichtausgelesen = $row['Gewicht'];
        $datumausgelesen = $row['Datum'];
        $data[] = array('Datum' => $datumausgelesen, 'Gewicht' => (float) $gewichtausgelesen);

        echo "<ul class='gewicht-liste'>";
        echo "<li>Gewicht: " . $gewichtausgelesen  . ", Datum: " . $datumausgelesen . "</li>";
        echo "</ul>";
      }

      // Daten in das JSON-Format konvertieren
      $json_data = json_encode($data);

      $result->free();
    }

    ?>

    <!-- Erstellen des Liniendiagramms mit Google Charts -->
    <div id="chart_div"></div>
    <script>
      // Laden der Charts API
      google.charts.load('current', {
        'packages': ['corechart']
      });

      // Erstellen der Callback-Funktion
      google.charts.setOnLoadCallback(drawChart);

      // Erstellen des Diagramms
      function drawChart() {
        // Daten in das JSON-Format konvertieren
        var jsonData = <?php echo $json_data; ?>;

        // Erstellen eines neuen DataTable-Objekts
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Datum');
        data.addColumn('number', 'Gewicht');

        // Daten hinzufügen
        for (var i = 0; i < jsonData.length; i++) {
          var date = new Date(jsonData[i].Datum);
          data.addRow([date, jsonData[i].Gewicht]);
        }

        // Erstellen des Liniendiagramms
        var options = {
          title: 'Gewicht über die Zeit',
          curveType: 'function',
          legend: {
            position: 'bottom'
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>














  </main><!-- End #main -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>