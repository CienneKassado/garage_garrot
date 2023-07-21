<?php

// Débogage
error_reporting(E_ALL);
ini_set("display_errors", 1);

$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST['message_id'])) {
    $messageId = $_POST['message_id'];
    
    $connexion = new mysqli($host_name, $user_name, $password, $database);

    if ($connexion->connect_error) {
      die("Échec de la connexion à la base de données : " . $connexion->connect_error);
    }

    $sql = "DELETE FROM contacts WHERE id_con = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $messageId);

    if ($stmt->execute()) {
      header("Location: message.php");
      exit();
    } else {
     
      echo "Erreur lors de la suppression du message : " . $connexion->error;
    }
    $stmt->close();
    $connexion->close();
  }
}
?>
