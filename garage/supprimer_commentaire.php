<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $commentaire_id = $_POST['commentaire_id'];
  $host_name = 'db5013809319.hosting-data.io';
  $database = 'dbs11556871';
  $user_name = 'dbu2118504';
  $password = '13x10y04z';
  $connexion = new mysqli($host_name, $user_name, $password, $database);

  if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
  }

  $sqlSuppression = "DELETE FROM commentaires WHERE id = $commentaire_id";
  $resultatSuppression = $connexion->query($sqlSuppression);

  if ($resultatSuppression === TRUE) {
    header('Location: accueil_admin.php');
    exit;
  } else {
    echo "Erreur lors de la suppression du commentaire : " . $connexion->error;
  }
}


$connexion->close();
?>
