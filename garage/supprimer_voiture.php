<?php
if (isset($_POST['id_voiture'])) {
    $id_voiture = $_POST['id_voiture'];

    $host_name = 'db5013809319.hosting-data.io';
    $database = 'dbs11556871';
    $user_name = 'dbu2118504';
    $password = '13x10y04z';
    $connexion = new mysqli($host_name, $user_name, $password, $database);

    if ($connexion->connect_error) {
        die("Échec de la connexion à la base de données : " . $connexion->connect_error);
    }

    $query = "DELETE FROM voitures WHERE id_v = '$id_voiture'";

    if ($connexion->query($query) === TRUE) {
        header("Location: modification_voitures.php");
    } else {
        echo "Erreur lors de la suppression de la voiture : " . $connexion->error;
    }

    $connexion->close();
}
?>
