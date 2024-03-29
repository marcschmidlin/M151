<?php
// Datenbankverbindung
include('./database/db_connector.inc.php');

// TODO - Session starten
session_start();
// variablen initialisieren
$error = $message = '';

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

    $vorname = $row['Vorname'];
    $nachname = $row['Name'];
    $email = $row['email'];
    $alter = $row['Alter'];
    $idBenutzer = $row['idBenutzer'];
  }

  $result->free();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

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

      <h1 class="logo me-auto me-lg-0"><a href="./index.php">FM Fitness<span>.</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto " href="./index.php">Home</a></li>
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
          <h2>Meine Trainingspläne</h2>
          <ol>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./inner-page.php">Übersicht</a></li>
            <li>Meine Trainingspläne</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->


    <section>

      <h2>Deine Trainingspläne</h2>


      <?php

      if (isset($_POST['deleteTrainingplan'])) {
        $idTrainingplan = $_POST['idTrainingplan'];

        // Query erstellen
        $query = "DELETE FROM uebungen WHERE Trainingplan_idTrainingplan=?";
        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
          $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }
        // Parameter an Query binden
        if (!$stmt->bind_param("i", $idTrainingplan)) {
          $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }
        // Query ausführen
        if (!$stmt->execute()) {
          $error .= 'execute() failed ' . $mysqli->error . '<br />';
        }

        // Query erstellen
        $query = "DELETE FROM Trainingplan WHERE idTrainingplan=?";
        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
          $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }
        // Parameter an Query binden
        if (!$stmt->bind_param("i", $idTrainingplan)) {
          $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }
        // Query ausführen
        if (!$stmt->execute()) {
          $error .= 'execute() failed ' . $mysqli->error . '<br />';
        }
      }




      if (empty($error)) {
        // Query erstellen
        $query = "SELECT * from Trainingplan where Benutzer_idBenutzer =?";

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

        while ($row = $result->fetch_assoc()) {
          $idTrainingplan = $row['idTrainingplan'];
          $nametraingplan = $row['Traingplanname'];


          echo '<div style="border: 1px solid black; padding: 10px; margin-bottom: 10px;">';
          echo '<h3>' . $nametraingplan . '</h3>';



          // Query erstellen
          $query2 = "SELECT * from uebungen where Trainingplan_idTrainingplan =?";

          // Query vorbereiten
          $stmt2 = $mysqli->prepare($query2);
          if ($stmt2 === false) {
            $error .= 'prepare() failed ' . $mysqli->error . '<br />';
          }
          // Parameter an Query binden
          if (!$stmt2->bind_param("s", $idTrainingplan)) {
            $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
          }
          // Query ausführen
          if (!$stmt2->execute()) {
            $error .= 'execute() failed ' . $mysqli->error . '<br />';
          }
          // Daten auslesen
          $result2 = $stmt2->get_result();

          echo '<ul>';
          while ($row2 = $result2->fetch_assoc()) {
            $uebung = $row2['Uebungname'];
            echo '<li>' . $uebung . '</li>';
          }
          echo '</ul>';

          // Button zum Löschen des Trainingsplans hinzufügen

          echo '<form method="POST" action="">';
          echo '<input type="hidden" name="idTrainingplan" value="' . $idTrainingplan . '">';

          echo '<button type="submit" name="deleteTrainingplan">Trainingsplan löschen</button>';
          echo '</form>';

          $result2->free();

          echo '</div>';
        }

        $result->free();
      }





      ?>







    </section>

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