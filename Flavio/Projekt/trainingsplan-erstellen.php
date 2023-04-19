<?php

$id=1;
// Datenbankverbindung
include('./database/db_connector.inc.php');

// TODO - Session starten
session_start();
// variablen initialisieren
$error = $message = '';
$uebungname = $zielmuskel =  $trainingsplanname = '';

if (!isset($_SESSION['loggedin']) or !$_SESSION['loggedin']) {
    // TODO - wenn keine Personalisierte Session
    $error .= "Sie sind nicht angemeldet, melden Sie sich bitte auf der  <a href='login.php'>Login-Seite</a> an.";
}else{
    // Session nicht OK,  Weiterleitung auf Anmeldung
    //  Script beenden// TODO -  Wenn personalisierte Session: Begrüssen des Benutzers mit Benutzernamen
    $email=  $_SESSION['email'] ;
$message .= "Hallo $email"  ;
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

  while($row = $result->fetch_assoc()){
    $idBenutzer = $row['idBenutzer'];
    $vorname = $row['Vorname'];
    $nachname = $row['Name'];
    $email = $row['email'];
    $alter = $row['Alter'];
    $gewicht = $row['Gewicht'];
}

$result->free();
}


// Abfrage ausführen, wenn keine Fehler vorhanden sind
if (empty($error)) {
    // Query vorbereiten
    $query = "SELECT * FROM uebungen";
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
        $uebungname = $row['Uebungname'];
        $zielmuskel1 = $row['Zielmuskel'];

      }
      $result->free();
    }

    // Statement schließen
    $stmt->close();
  }





//ID ZU Trainingsplan hinzufügen
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Trainingsplan ausgefüllt?
  if (isset($_POST['trainingplanname'])) {
    //trim and sanitize
    $trainingplanname = htmlspecialchars(trim($_POST['trainingplanname']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($trainingplanname) || strlen($trainingplanname) > 30) {
      $error .= "Geben Sie bitte einen korrekten Zielmuskel ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Zielmuskel ein.<br />";
  }




    
    $query = "Insert into trainingplan (Benutzer_idBenutzer, Traingplanname) values (?,?)";
    
    
    // Query vorbereiten
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
      $error .= 'prepare() failed ' . $mysqli->error . '<br />';
    }
    
    // Parameter an Query binden
    if (!$stmt->bind_param('ss', $idBenutzer, $trainingplanname)) {
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

    
      // Weiterleiten auf login.php
     
      // beenden des Scriptes
      
    }
  }


// SELECT ID from trainingsplan
if (empty($error)) {
    // Query vorbereiten
    $query = "SELECT * FROM trainingplan";
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
        $idTrainingplan = $row['idTrainingplan'];
      }
      $result->free();
    }

    // Statement schließen
    $stmt->close();
  }


  //Übung 1

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Uebungsname ausgefüllt?
  if (isset($_POST['uebungname1'])) {
    //trim and sanitize
    $uebungname1 = htmlspecialchars(trim($_POST['uebungname1']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($uebungname1) || strlen($uebungname1) > 30) {
      $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Uebungsnamen ein.<br />";
  }


  // Zielmuskel ausgefüllt?
  if (isset($_POST['zielmuskel1'])) {
    //trim and sanitize
    $zielmuskel1 = htmlspecialchars(trim($_POST['zielmuskel1']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($zielmuskel1) || strlen($zielmuskel1) > 30) {
      $error .= "Geben Sie bitte einen korrekten Zielmuskel ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Zielmuskel ein.<br />";
  }



//Übung zwei

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Uebungsname ausgefüllt?
  if (isset($_POST['uebungname2'])) {
    //trim and sanitize
    $uebungname2 = htmlspecialchars(trim($_POST['uebungname2']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($uebungname2) || strlen($uebungname2) > 30) {
      $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Uebungsnamen ein.<br />";
  }


  // Zielmuskel ausgefüllt?
  if (isset($_POST['zielmuskel2'])) {
    //trim and sanitize
    $zielmuskel2 = htmlspecialchars(trim($_POST['zielmuskel2']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($zielmuskel2) || strlen($zielmuskel2) > 30) {
      $error .= "Geben Sie bitte einen korrekten Zielmuskel ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Zielmuskel ein.<br />";
  }

     // Uebungsname ausgefüllt?
     if (isset($_POST['uebungname3'])) {
        //trim and sanitize
        $uebungname3 = htmlspecialchars(trim($_POST['uebungname3']));
    
        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($uebungname3) || strlen($uebungname3) > 30) {
          $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
        }
      } else {
        $error .= "Geben Sie bitte einen Uebungsnamen ein.<br />";
      }
    
    
      // Zielmuskel ausgefüllt?
      if (isset($_POST['zielmuskel3'])) {
        //trim and sanitize
        $zielmuskel3 = htmlspecialchars(trim($_POST['zielmuskel3']));
    
        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($zielmuskel3) || strlen($zielmuskel3) > 30) {
          $error .= "Geben Sie bitte einen korrekten Zielmuskel ein.<br />";
        }
      } else {
        $error .= "Geben Sie bitte einen Zielmuskel ein.<br />";
      }

    $query = "Insert into uebungen (Uebungname, Zielmuskel, Trainingplan_idTrainingplan) values (?,?,?), (?,?,?), (?,?,?)";
    
    // Query vorbereiten
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
      $error .= 'prepare() failed ' . $mysqli->error . '<br />';
    }
    
    // Parameter an Query binden
    if (!$stmt->bind_param('sssssssss', $uebungname1, $zielmuskel1, $idTrainingplan, $uebungname2, $zielmuskel2, $idTrainingplan, $uebungname3, $zielmuskel3, $idTrainingplan)) {
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
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
<style>
		/* Stil für das Pop-up */
		#popup {
			display: none;
			position: fixed;
			z-index: 1;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgba(0, 0, 0, 0.4);
		}

		/* Stil für das Formular im Pop-up */
		#form {
			background-color: #fefefe;
			margin: 15% auto;
			padding: 20px;
			border: 1px solid #888;
			width: 80%;
		}
	</style>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-inner-pages">
    <div class="container d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="index.html">Gp<span>.</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto " href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li><a class="nav-link scrollto " href="#portfolio">Portfolio</a></li>
          <li><a class="nav-link scrollto" href="#team">Team</a></li>
          <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="#about" class="get-started-btn scrollto">Get Started</a>

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Inner Page</h2>
          <ol>
            <li><a href="index.html">Home</a></li>
            <li>Inner Page</li>
          </ol>
        </div>

      </div>
      <section class="inner-page">
      <div class="container">
        <h2>
          Erstelle einen neuen Trainingsplan für <?php echo $vorname?>
</h2>
      </div>
      
    

		
        <form action="" method="post">

<label for="trainingplanname">Trainingsplan Name:</label>

<input type="text" id="trainingplanname" name="trainingplanname"><br><br>
			<h2>Übung hinzufügen</h2>
			<form>
				<!-- Übungsname -->
				
					<label for="uebungname">Übungsname:</label>
					<input type="text" id="uebungname" name="uebungname1" placeholder="Geben Sie den Übungsnamen an." maxlength="30" required>
				

				<!-- Zielmuskel -->
				
					<label for="zielmuskel">Zielmuskel:</label>
					<input type="text" id="zielmuskel" name="zielmuskel1" placeholder="Geben Sie den Zielmuskel an." maxlength="30" required><br>


                    <label for="uebungname2">Übungsname:</label>
					<input type="text" id="uebungname" name="uebungname2" placeholder="Geben Sie den Übungsnamen an." maxlength="30" required>

					<label for="zielmuskel2">Zielmuskel:</label>
					<input type="text" id="zielmuskel2" name="zielmuskel2" placeholder="Geben Sie den Zielmuskel an." maxlength="30" required><br>

                    <label for="uebungname2">Übungsname:</label>
					<input type="text" id="uebungname" name="uebungname3" placeholder="Geben Sie den Übungsnamen an." maxlength="30" required>

					<label for="zielmuskel2">Zielmuskel:</label>
					<input type="text" id="zielmuskel2" name="zielmuskel3" placeholder="Geben Sie den Zielmuskel an." maxlength="30" required><br>
				

				

                <button type="submit" name="button" value="submit" class="btn btn-info">Speichern</button>
                

                <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
          <a href="./trainingsplan.php">
            <div class="icon-box">
              <div class="icon"><i class="bx bxl-dribbble"></i></div>
              <h4><a href="./trainingsplan.php">Öffne deine Trainingspläne</a></h4>
              <p>Verwende einer deiner erstellten Trainingspläne</p>
            </div>
            </a>
          </div>

</a>
        </div>

			</form>


 

    </section>




  

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Gp<span>.</span></h3>
              <p>
                A108 Adam Street <br>
                NY 535022, USA<br><br>
                <strong>Phone:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Gp</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

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