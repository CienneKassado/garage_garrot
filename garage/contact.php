<?php

// Débogage
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Base pour les contact
session_start();
$host_name = 'db5013809319.hosting-data.io';
 $database = 'dbs11556871';
 $user_name = 'dbu2118504';
 $password = '13x10y04z';
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  if (empty($nom) || empty($prenom) || empty($email) || empty($message)) {
    die("Veuillez remplir tous les champs du formulaire.");
  }

 $connexion = new mysqli($host_name, $user_name, $password, $database);

  if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
  }

  $sql = "INSERT INTO contacts (nom_con, prenom_con, mail_con, message_con) VALUES (?, ?, ?, ?)";
  $stmt = $connexion->prepare($sql);
  $stmt->bind_param("ssss", $nom, $prenom, $email, $message);

  if ($stmt->execute()) {
    $_SESSION['message'] = "Message envoyé avec succès !";
    header("Location: contact.php");
    exit;
  } else {
    $_SESSION['message'] = "Une erreur s'est produite lors de l'envoi du message : " . $stmt->error;
    header("Location: contact.php");
    exit;
  } 
}

// Base pour les infos
 $connexion = new mysqli($host_name, $user_name, $password, $database);

if ($connexion->connect_error) {
  die("Échec de la connexion à la base de données : " . $connexion->connect_error);
}

$sql_infos = "SELECT * FROM infos";
$resultat_infos = $connexion->query($sql_infos);

if (!$resultat_infos) {
  die("Une erreur s'est produite lors de la récupération des informations : " . $connexion->error);
}

$row_infos = $resultat_infos->fetch_assoc();

$email = $row_infos['email'];
$telephone = $row_infos['telephone'];

$resultat_infos->close();
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Contactez nous</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="icon" href="images/garrot.png" type="image/x-icon">
  <link rel="stylesheet" href="contact_style.css">
</head>
<body>

<!-- Header -->
<header class="text-center py-4">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-2">
        <a href="index.php">
          <img src="images/garrot.png" alt="Logo" class="logo img-fluid" style="max-width: 100px; margin-top: 7px;">
        </a>
      </div>
      <div class="col-md-8">
        <h1 class="title">Le Garage de Mr Parrot</h1>
      </div>
      <div class="col-md-2 text-end">
        <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="images/connexion.svg" alt="Connecter" class="connect-svg img-fluid" style="max-width: 60px; margin-top: 7px;">
          </button>
          <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="index.php">Page d'accueil</a>
            <a class="dropdown-item" href="connexion.php">Se connecter</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Contenu principal -->
<div class="container mt-4">
  <h2 class="text-center">Contactez-nous</h2>

  <?php
  // Vérifiez si un message de session existe
  if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-' . ($_SESSION['message'] == "Message envoyé avec succès !" ? "success" : "danger") . '">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
  }
  ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="mb-3">
      <label for="nom" class="form-label">Nom :</label>
      <input type="text" class="form-control" id="nom" name="nom" required>
    </div>
    <div class="mb-3">
      <label for="prenom" class="form-label">Prénom :</label>
      <input type="text" class="form-control" id="prenom" name="prenom" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Adresse email :</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="message" class="form-label">Message :</label>
      <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary mx-auto d-block">Envoyer</button>
  </form>
</div>

<!-- Footer -->
<footer class="text-center py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p>Le Garage de Mr Parrot - Tous droits réservés &copy; <?php echo date('Y'); ?></p>
        <p>Contact : <?php echo $email; ?> - Tél : <?php echo $telephone; ?></p>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
