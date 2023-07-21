<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nom = $_POST["nom"];
  $prenom = $_POST["prenom"];
  $email = $_POST["email"];
  $telephone = $_POST["telephone"];
  $rang = $_POST["rang"];
  $motDePasse = $_POST["motDePasse"];
  $confirmationMotDePasse = $_POST["confirmationMotDePasse"];


  // Verification mot de passe
  if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $motDePasse)) {
    $messageErreur = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
  } else if ($motDePasse !== $confirmationMotDePasse) {
    $messageErreur = "Les mots de passe ne correspondent pas.";
  } else {
    $connexion = new mysqli($host_name,  $user_name,$password,$database );

    if ($connexion->connect_error) {
      die("Échec de la connexion à la base de données : " . $connexion->connect_error);
    }

    $requeteVerifEmail = "SELECT * FROM comptes WHERE mail = '$email'";
    $resultatVerifEmail = $connexion->query($requeteVerifEmail);

    if ($resultatVerifEmail->num_rows > 0) {
      $messageErreur = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
      $requete = "INSERT INTO comptes (nom, prenom, mail, telephone, rang, mot_de_passe) VALUES ('$nom', '$prenom', '$email', '$telephone', '$rang', '$motDePasse')";
      if ($connexion->query($requete) === true) {
        header("Location: connexion.php");
        exit;
      } else {
        $messageErreur = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
      }
    }

    $connexion->close();
  }
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscrivez un nouveau membre</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="icon" href="images/garrot.png" type="image/x-icon">
  <link rel="stylesheet" href="connexion.css">


</head>
<body>
  
<nav class="navbar navbar-expand-lg navbar-light custom-nav">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="navbar-brand" href="index.php">
            <img src="images/garrot.png" alt="Logo" class="logo img-fluid" style="max-width: 120px; margin-top: 7px; margin-right: 20px;">
          </a>
          
        </li>
        <li class="nav-item">
          <a class="nav-link" href="accueil_admin.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="message.php">Mes Messages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="modification_voitures.php">Mes véhicules</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Se déconnecter</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-md-6">
       
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mt-4">
          <?php if (isset($messageErreur)) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $messageErreur; ?>
            </div>
          <?php } ?>
          <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="prenom" class="form-label">Prénom :</label>
            <input type="text" name="prenom" id="prenom" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email :</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="motDePasse" class="form-label">Mot de passe :</label>
            <input type="password" name="motDePasse" id="motDePasse" class="form-control" required>
            <small class="form-text text-muted">Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.</small>
          </div>

          <div class="mb-3">
            <label for="confirmationMotDePasse" class="form-label">Confirmation du mot de passe :</label>
            <input type="password" name="confirmationMotDePasse" id="confirmationMotDePasse" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone :</label>
            <input type="text" name="telephone" id="telephone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="rang" class="form-label">Rang :</label>
            <input type="text" name="rang" id="rang" class="form-control" required>
          </div>
         
         
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
