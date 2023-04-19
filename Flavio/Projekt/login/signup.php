<?php

// TODO - Sessionhandling starten
session_start();


// Datenbankverbindung
include('../database/db_connector.inc.php');

// Initialisierung
$error = $message =  '';
$firstname = $lastname = $email = $password =  '';

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // Vorname ausgefüllt?
  if (isset($_POST['firstname'])) {
    //trim and sanitize
    $firstname = htmlspecialchars(trim($_POST['firstname']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($firstname) || strlen($firstname) > 30) {
      $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Vornamen ein.<br />";
  }

  // Nachname ausgefüllt?
  if (isset($_POST['lastname'])) {
    //trim and sanitize
    $lastname = htmlspecialchars(trim($_POST['lastname']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($lastname) || strlen($lastname) > 30) {
      $error .= "Geben Sie bitte einen korrekten Nachname ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Nachname ein.<br />";
  }

  // Email ausgefüllt?
  if (isset($_POST['email'])) {
    //trim an sanitize
    $email = htmlspecialchars(trim($_POST['email']));

    //mindestens 1 Zeichen und maximal 100 Zeichen lang, gültige Emailadresse
    if (empty($email) || strlen($email) > 100 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      $error .= "Geben Sie bitte eine korrekten Emailadresse ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte eine Emailadresse ein.<br />";
  }



  // Passwort ausgefüllt
  if (isset($_POST['password'])) {
    //trim and sanitize
    $password = trim($_POST['password']);

    //mindestens 1 Zeichen , entsprich RegEX
    if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
      $error .= "Geben Sie bitte einen korrektes Password ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte ein Password ein.<br />";
  }

  if (empty($error)) {

    // Query erstellen
    $query1 = "SELECT * FROM benutzer WHERE email= ?";

    // Query vorbereiten
    $stmt1 = $mysqli->prepare($query1);
    if ($stmt1 === false) {
      $error .= 'prepare() failed ' . $mysqli->error . '<br />';
    }

    // Parameter an Query binden
    if (!$stmt1->bind_param('s', $email)) {
      $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
    }


    // Query ausführen und Resultset speichern
    if (!$stmt1->execute()) {
      $error .= 'execute() failed ' . $mysqli->error . '<br />';
    }
    $result1 = $stmt1->get_result();

    // Anzahl der Zeilen im Resultset prüfen
    if (mysqli_num_rows($result1) != 0) {
      $error .= "Email schon vorhanden<br />";
    } else {
      // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
      if (empty($error)) {

        // Password haschen
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Query erstellen
        $query = "Insert into benutzer (Name, Vorname, email, Passwort) values (?,?,?,?)";

        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
          $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }

        // Parameter an Query binden
        if (!$stmt->bind_param('ssss', $lastname, $firstname, $email, $password_hash)) {
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
          $username = $password = $firstname = $lastname = $email =  '';
          // Verbindung schliessen
          $mysqli->close();
          // Weiterleiten auf login.php
          header('Location: ./signin.php');
          // beenden des Scriptes
          exit();
        }
      }
    }
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <title>FM Fitness Registrieren</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <section class="ftco-section">
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-10">
        <div class="wrap d-md-flex">
          <div class="img" style="background-image: url(images/bg-1.jpg);">
          </div>
          <div class="login-wrap p-4 p-md-5">
            <div class="d-flex">
              <div class="w-100">
                <h3 class="mb-4">Registrieren</h3>
              </div>
              <div class="w-100">
                <p class="social-media d-flex justify-content-end">
                  <a href="https://de-de.facebook.com/" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                  <a href="https://twitter.com/?lang=de" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                </p>
              </div>

            </div>
            <?php
            // Ausgabe der Fehlermeldungen
            if (!empty($error)) {
              echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
            } else if (!empty($message)) {
              echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
            }
            ?>
            <form method="post">
              <!-- vorname -->
              <div class="form-group">
                <label for="firstname">Vorname *</label>
                <input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo $firstname ?>" placeholder="Geben Sie Ihren Vornamen an." maxlength="30">
              </div>
              <!-- nachname -->
              <div class="form-group">
                <label for="lastname">Nachname *</label>
                <input type="text" name="lastname" class="form-control" id="lastname" value="<?php echo $lastname ?>" placeholder="Geben Sie Ihren Nachnamen an" maxlength="30">
              </div>
              <!-- email -->
              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo $email ?>" placeholder="Geben Sie Ihre Email-Adresse an." maxlength="100">
              </div>
              <!-- benutzername -->

              <!-- password -->
              <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute." maxlength="255">
              </div>
              <!-- Send / Reset -->
              <button type="submit" name="button" value="submit" class="btn btn-info">Anmelden</button>
              <p class="text-center">Schon ein Account? <a href="./signin.php">Sign In</a></p>
            </form>
          </div>
          </div>
          </div>
          </div>



  </section>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

</body>

</html>