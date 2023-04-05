<?php


// TODO - Sessionhandling starten
session_start();


// Datenbankverbindung
include('../database/db_connector.inc.php');

$error = '';
$message = '';
$email = $password = '';


// Formular wurde gesendet und Besucher ist noch nicht angemeldet.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// email
	if (isset($_POST['email'])) {
		//trim and sanitize
		$email = htmlspecialchars(trim($_POST['email']));

		// Prüfung email
		if (empty($email) || strlen($email) > 100 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$error .= "Email entspricht nicht dem geforderten Format.<br />";
		}
	} else {
		$error .= "Geben Sie bitte den Benutzername an.<br />";
	}
	// password
	if (isset($_POST['Passwort'])) {
		//trim and sanitize
		$password = trim($_POST['Passwort']);
		// passwort gültig?
		if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
			$error .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
		}
	} else {
		$error .= "Geben Sie bitte das Passwort an.<br />";
	}

	
	// kein Fehler
	if (empty($error)) {
		// Query erstellen
		$query = "SELECT email, Passwort from benutzer where email =?";
		
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

		// Userdaten lesen
		if ($row = $result->fetch_assoc()) {

			// Passwort ok?
			if (password_verify($password, $row['Passwort'])) {

				// TODO - Session personifizieren
				$_SESSION['loggedin'] = true;
				$_SESSION['email'] = $email;
				
				
				// TODO - Session ID regenerieren
				session_regenerate_id();
				// TODO - weiterleiten auf admin.php
				header('location: ../inner-page.php');
				// TODO - Script beenden
				exit;

			} else {
				$error .= "Benutzername oder Passwort sind falsch";
			}
		} else {
			$error .= "Benutzername oder Passwort sind falsch";
		}
	}
}

?>


<!doctype html>
<html lang="en">
  <head>
  	<title>FM Fitness Login</title>
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
			      			<h3 class="mb-4">Sign In</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="https://de-de.facebook.com/" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="https://twitter.com/?lang=de" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
									</p>
								</div>
			      	</div>



					  <?php
		// fehlermeldung oder nachricht ausgeben
		if (!empty($message)) {
			echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
		} else if (!empty($error)) {
			echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
		}
		?>
					  <form action="" method="POST">
			<div class="form-group">
				<label for="emaiö">Benutzername *</label>
				<input type="email" name="email" class="form-control" id="email" value="" placeholder="emailadresse" required="true">
			</div>
			<!-- password -->
			<div class="form-group">
				<label for="Passwort">Password *</label>
				<input type="password" name="Passwort" class="form-control" id="Passwort" placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute." maxlength="255" required="true">
			</div>
			<button type="submit" name="button" value="submit" class="btn btn-info">Senden</button>
			
		</form>
			



			
		            <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div>
		            </div>
		          </form>
		          <p class="text-center">Noch kein Account? <a href="signup.php">Sign Up</a></p>
		        </div>
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

