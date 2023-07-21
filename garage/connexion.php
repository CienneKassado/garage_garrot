<?php

//Débogage
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST["email"];
  $motDePasse = $_POST["motDePasse"];

$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';
$connexion = new mysqli($host_name, $user_name, $password, $database);
 
 if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
  }

  $requete = "SELECT * FROM comptes WHERE mail = '$email' AND mot_de_passe = '$motDePasse'";
  $resultat = $connexion->query($requete);

  if ($resultat->num_rows === 1) {
    $row = $resultat->fetch_assoc();
    $rang = $row['rang'];

    if ($rang === 'Administrateur') {
      $connexion->close();
      header("Location: accueil_admin.php");
      exit;

    } else {
      $connexion->close();
      header("Location: accueil_employe.php");
      exit;
    }
  } else {
    $_SESSION['messageErreur'] = "Email ou mot de passe incorrect.";
    $connexion->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }
}

$messageErreur = isset($_SESSION['messageErreur']) ? $_SESSION['messageErreur'] : '';
unset($_SESSION['messageErreur']);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap" rel="stylesheet">  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="images/garrot.png" type="image/x-icon">
  <link rel="stylesheet" href="connexion.css">
</head>

<body>

<header class="text-center py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-2">
          <img src="images/garrot.png" alt="Logo" class="logo img-fluid" style="max-width: 100px; margin-top: 7px;">
        </div>
        <div class="col-md-8">
          <h1 class="title" style="font-size: 76px; margin-top: 10px;">Le Garage de Mr Parrot</h1>
        </div>
      
      </div>
    </div>
  </header>

<div class="container h-100">
  <div class="row form-row h-100 justify-content-center align-items-center">
    <div class="col-md-6 mt-5 mb-0">
     
      <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mt-4">
        <?php if ($messageErreur !== '') { ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $messageErreur; ?>
          </div>
        <?php } ?>
        <div class="mb-3">
          <label for="email" class="form-label">Email :</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="motDePasse" class="form-label">Mot de passe :</label>
          <input type="password" name="motDePasse" id="motDePasse" class="form-control" required>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Connexion</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
