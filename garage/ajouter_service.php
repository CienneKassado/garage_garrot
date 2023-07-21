<?php

//Débogage
error_reporting(E_ALL);
ini_set("display_errors", 1);

$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $nouveau_nom = $_POST['nom'];
  $nouvelle_description = $_POST['description'];

  if (!empty($nouveau_nom) && !empty($nouvelle_description)) {
   
    $connexion = new mysqli($host_name, $user_name, $password, $database);
    if ($connexion->connect_error) {
      die("Échec de la connexion à la base de données : " . $connexion->connect_error);
    }
    $sqlInsertion = "INSERT INTO services (nom, description) VALUES ('$nouveau_nom', '$nouvelle_description')";
    if ($connexion->query($sqlInsertion) === TRUE) {
      header("Location: accueil_admin.php?message=Le nouveau service a été ajouté avec succès.&type=success");
      exit();
    } else {
      header("Location: accueil_admin.php?message=Erreur lors de l'ajout du service.&type=error");
      exit();
    }
  } else {
    header("Location: accueil_admin.php?message=Veuillez remplir tous les champs du formulaire.&type=error");
    exit();
  }
} 
?>
