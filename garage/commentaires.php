<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$previousPage = $_SERVER['HTTP_REFERER'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
  $nom = $_POST['nom'];
  $notes = $_POST['notes'];
  $commentaire = $_POST['commentaire'];

  $host_name = 'db5013809319.hosting-data.io';
  $database = 'dbs11556871';
  $user_name = 'dbu2118504';
  $password = '13x10y04z';
  $connexion = new mysqli($host_name, $user_name, $password, $database);
 
  if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
  }

  // Vérifier si la note est présente et différente de zéro
  if (isset($notes) && $notes != 0) {
    $sql = "INSERT INTO commentaires (nom, notes, commentaires) VALUES (?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("sis", $nom, $notes, $commentaire);

    if ($stmt->execute()) {
      header("Location: " . $previousPage);
      exit();
    }
  } else {
    // Si la note est absente ou nulle, insérer sans la note
    $sql = "INSERT INTO commentaires (nom, commentaires) VALUES (?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ss", $nom, $commentaire);

    if ($stmt->execute()) {
      echo '<script>history.back();</script>';
      exit();
    }
  }


  $stmt->close();
  $connexion->close();
}
?>
