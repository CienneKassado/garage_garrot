<?php

//Déboggage
error_reporting(E_ALL);
ini_set("display_errors", 1);
$previousPage = $_SERVER['HTTP_REFERER'];

$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';



$allowedImageTypes = array("jpg", "jpeg", "png", "gif");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $connexion = new mysqli($host_name, $user_name, $password, $database);

    if ($connexion->connect_error) {
        die("Échec de la connexion à la base de données : " . $connexion->connect_error);
    }
    $voitureId = $_POST["voiture_id"];
    $nom = $_POST["nom"];
    $prix = $_POST["prix"];
    $annee = $_POST["annee"];
    $kilometrage = $_POST["kilometrage"];

    $targetDir = "images/";
    $targetFile1 = $targetDir . basename($_FILES["image1Vehicule"]["name"]);
    $uploadOk1 = 1;

    if (!empty($_FILES["image1Vehicule"]["name"])) {
        // Vérifie si le fichier est une image valide
        $check1 = getimagesize($_FILES["image1Vehicule"]["tmp_name"]);
        if ($check1 === false) {
            echo "Le fichier de l'image 1 n'est pas une image valide.";
            $uploadOk1 = 0;
        }

        // Vérifie la taille du fichier
        if ($_FILES["image1Vehicule"]["size"] > 50000000) {
            echo "Désolé, votre fichier image 1 est trop volumineux.";
            $uploadOk1 = 0;
        }

        // Autorise uniquement certains formats d'image
        $allowedImageTypes = array("jpg", "jpeg", "png", "gif");
        $imageFileType1 = strtolower(pathinfo($targetFile1, PATHINFO_EXTENSION));
        if (!in_array($imageFileType1, $allowedImageTypes)) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés pour l'image 1.";
            $uploadOk1 = 0;
        }
    }

    // Image 2
    $targetFile2 = $targetDir . basename($_FILES["image2Vehicule"]["name"]);
    $uploadOk2 = 1;

    if (!empty($_FILES["image2Vehicule"]["name"])) {
        $check2 = getimagesize($_FILES["image2Vehicule"]["tmp_name"]);
        if ($check2 === false) {
            echo "Le fichier de l'image 2 n'est pas une image valide.";
            $uploadOk2 = 0;
        }

        if ($_FILES["image2Vehicule"]["size"] > 50000000) {
            echo "Désolé, votre fichier image 2 est trop volumineux.";
            $uploadOk2 = 0;
        }

        $imageFileType2 = strtolower(pathinfo($targetFile2, PATHINFO_EXTENSION));
        if (!in_array($imageFileType2, $allowedImageTypes)) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés pour l'image 2.";
            $uploadOk2 = 0;
        }
    }

    // Image 3
    $targetFile3 = $targetDir . basename($_FILES["image3Vehicule"]["name"]);
    $uploadOk3 = 1;

    if (!empty($_FILES["image3Vehicule"]["name"])) {
        $check3 = getimagesize($_FILES["image3Vehicule"]["tmp_name"]);
        if ($check3 === false) {
            echo "Le fichier de l'image 3 n'est pas une image valide.";
            $uploadOk3 = 0;
        }

        if ($_FILES["image3Vehicule"]["size"] > 50000000) {
            echo "Désolé, votre fichier image 3 est trop volumineux.";
            $uploadOk3 = 0;
        }

        $imageFileType3 = strtolower(pathinfo($targetFile3, PATHINFO_EXTENSION));
        if (!in_array($imageFileType3, $allowedImageTypes)) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés pour l'image 3.";
            $uploadOk3 = 0;
        }
    }

    // Vérifie si $uploadOk est défini à 0 en cas d'erreur pour n'importe quelle image

    if ($uploadOk1 == 0 || $uploadOk2 == 0 || $uploadOk3 == 0) {
        echo "Désolé, un ou plusieurs de vos fichiers n'ont pas été téléchargés.";
   
    } else {
        $getInfoQuery = "SELECT * FROM voitures WHERE id_v = '$voitureId'";
        $result = $connexion->query($getInfoQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($nom)) {
                $nom = $row["nom_v"];
            }
            if (empty($prix)) {
                $prix = $row["prix"];
            }
            if (empty($annee)) {
                $annee = $row["annee"];
            }
            if (empty($kilometrage)) {
                $kilometrage = $row["kilometrage"];
            }
        }

        // Téléchargement des images
        if (!empty($_FILES["image1Vehicule"]["name"])) {
            move_uploaded_file($_FILES["image1Vehicule"]["tmp_name"], $targetFile1);
        }
        if (!empty($_FILES["image2Vehicule"]["name"])) {
            move_uploaded_file($_FILES["image2Vehicule"]["tmp_name"], $targetFile2);
        }
        if (!empty($_FILES["image3Vehicule"]["name"])) {
            move_uploaded_file($_FILES["image3Vehicule"]["tmp_name"], $targetFile3);
        }

        $query = "UPDATE voitures SET nom_v='$nom', prix='$prix', annee='$annee', kilometrage='$kilometrage'";

        if (!empty($_FILES["image1Vehicule"]["name"])) {
            $query .= ", image1='" . basename($_FILES["image1Vehicule"]["name"]) . "'";
        }
        if (!empty($_FILES["image2Vehicule"]["name"])) {
            $query .= ", image2='" . basename($_FILES["image2Vehicule"]["name"]) . "'";
        }
        if (!empty($_FILES["image3Vehicule"]["name"])) {
            $query .= ", image3='" . basename($_FILES["image3Vehicule"]["name"]) . "'";
        }

        $query .= " WHERE id_v='$voitureId'";

        if ($connexion->query($query) === TRUE) {
            header("Location: modification_voitures.php");
        } else {
            echo "Erreur lors de la mise à jour : " . $connexion->error;
        }
    }
    $connexion->close();
}
?>
