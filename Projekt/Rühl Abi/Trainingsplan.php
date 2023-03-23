<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Trainingplan erstellen</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header>
      <h1>Trainingplan erstellen</h1>
      <nav>
        <ul>
          <li><a href="index.php">Startseite</a></li>
          <li><a href="#">Übungen</a></li>
          <li><a href="#">Trainingpläne</a></li>
          <li><a href="#">Login</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <section>
        <h2>Trainingplan erstellen</h2>
        <?php if(isset($success) && $success) { ?>
          <div class="success">Trainingplan erfolgreich gespeichert!</div>
        <?php } ?>
        <form action="create-plan.php" method="post">
          <label for="plan-name">Name des Trainingsplans:</label>
          <input type="text" id="plan-name" name="plan-name" required>
          <fieldset>
            <legend>Übungen:</legend>
            <div>
              <label for="exercise-1">Übung 1:</label>
              <input type="text" id="exercise-1" name="exercise[]" required>
            </div>
            <div>
              <label for="exercise-2">Übung 2:</label>
              <input type="text" id="exercise-2" name="exercise[]" required>
            </div>
            <div>
              <label for="exercise-3">Übung 3:</label>
              <input type="text" id="exercise-3" name="exercise[]" required>
            </div>
          </fieldset>
          <button type="submit">Speichern</button>
        </form>
      </section>
    </main>
    <footer>
      <p>&copy; 2023 Trainingplan erstellen</p
