<?php


$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $service_id = $_POST['service_id'];
  $connexion = new mysqli($host_name, $user_name, $password, $database);

  if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
  }
  $sql_suppression = "DELETE FROM services WHERE id = '$service_id'";
  $resultat_suppression = $connexion->query($sql_suppression);

  if ($resultat_suppression === TRUE) {
    header("Location: accueil_admin.php");
    exit();
  } else {
    echo "Erreur lors de la suppression du service : " . $connexion->error;
  }
}
?>
