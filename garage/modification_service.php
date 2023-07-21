<?php

$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['service_id']) && isset($_POST['service_nom']) && isset($_POST['service_description'])) {
        $service_id = $_POST['service_id'];
        $service_nom = $_POST['service_nom'];
        $service_description = $_POST['service_description'];

        // Échapper correctement le texte pour éviter les injections SQL
        $connexion = new mysqli($host_name, $user_name, $password, $database);
        if ($connexion->connect_error) {
            die("Échec de la connexion à la base de données : " . $connexion->connect_error);
        }

        $service_nom = $connexion->real_escape_string($service_nom);
        $service_description = $connexion->real_escape_string($service_description);

        $sqlMiseAJour = "UPDATE services SET nom = '$service_nom', description = '$service_description' WHERE id = '$service_id'";
        if ($connexion->query($sqlMiseAJour) === TRUE) {
            header('Location: accueil_admin.php');
            exit;
        } else {
            echo "Erreur lors de la mise à jour du service : " . $connexion->error;
        }
    }
}
?>
