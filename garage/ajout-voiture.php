<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$previousPage = $_SERVER['HTTP_REFERER'];


$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prix = $_POST["prix"];
    $annee = $_POST["annee"];
    $kilometrage = $_POST["kilometrage"];

    // Téléchargement des images
    $targetDir = "images/";

    // Image 1
    $targetFile1 = $targetDir . basename($_FILES["image1"]["name"]);
    $imageFileType1 = strtolower(pathinfo($targetFile1, PATHINFO_EXTENSION));
    $uploadOk1 = 1;

    // Vérifie si le fichier est une image valide
    if (isset($_FILES["image1"]["tmp_name"])) {
        $check1 = getimagesize($_FILES["image1"]["tmp_name"]);
        if ($check1 === false) {
            echo "Le fichier de l'image 1 n'est pas une image valide.";
            $uploadOk1 = 0;
        }

        // Vérifie les extensions autorisées pour l'image 1
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType1, $allowedExtensions)) {
            echo "Désolé, seuls les fichiers JPG, JPEG et PNG sont autorisés pour l'image 1.";
            $uploadOk1 = 0;
        }
    }

    // Image 2
    $targetFile2 = $targetDir . basename($_FILES["image2"]["name"]);
    $imageFileType2 = strtolower(pathinfo($targetFile2, PATHINFO_EXTENSION));
    $uploadOk2 = 1;

   
    if (!empty($_FILES["image2"]["tmp_name"])) {
        $check2 = getimagesize($_FILES["image2"]["tmp_name"]);
        if ($check2 === false) {
            echo "Le fichier de l'image 2 n'est pas une image valide.";
            $uploadOk2 = 0;
        }

       
        if (!in_array($imageFileType2, $allowedExtensions)) {
            echo "Désolé, seuls les fichiers JPG, JPEG et PNG sont autorisés pour l'image 2.";
            $uploadOk2 = 0;
        }
    }

    // Image 3
    $targetFile3 = $targetDir . basename($_FILES["image3"]["name"]);
    $imageFileType3 = strtolower(pathinfo($targetFile3, PATHINFO_EXTENSION));
    $uploadOk3 = 1;

    if (!empty($_FILES["image3"]["tmp_name"])) {
        $check3 = getimagesize($_FILES["image3"]["tmp_name"]);
        if ($check3 === false) {
            echo "Le fichier de l'image 3 n'est pas une image valide.";
            $uploadOk3 = 0;
        }

        if (!in_array($imageFileType3, $allowedExtensions)) {
            echo "Désolé, seuls les fichiers JPG, JPEG et PNG sont autorisés pour l'image 3.";
            $uploadOk3 = 0;
        }
    }

    // Vérifie la taille des fichiers
    if ($_FILES["image1"]["size"] > 50000000 || $_FILES["image2"]["size"] > 50000000 || $_FILES["image3"]["size"] > 50000000) {
        echo "Désolé, un ou plusieurs de vos fichiers sont trop volumineux.";
        $uploadOk1 = $uploadOk2 = $uploadOk3 = 0;
    }

    // Vérifie si $uploadOk est défini à 0 en cas d'erreur
    if ($uploadOk1 == 0 || $uploadOk2 == 0 || $uploadOk3 == 0) {
        echo "Désolé, un ou plusieurs de vos fichiers n'ont pas été téléchargés.";
    } else {
        if (move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile1)) {
            echo "Le fichier image 1 a été téléchargé avec succès.";
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement du fichier image 1.";
        }

        if (!empty($_FILES["image2"]["tmp_name"])) {
            if (move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile2)) {
                echo "Le fichier image 2 a été téléchargé avec succès.";
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement du fichier image 2.";
            }
        }

        if (!empty($_FILES["image3"]["tmp_name"])) {
            if (move_uploaded_file($_FILES["image3"]["tmp_name"], $targetFile3)) {
                echo "Le fichier image 3 a été téléchargé avec succès.";
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement du fichier image 3.";
            }
        }

        $image1Name = basename($_FILES["image1"]["name"]);
        $image2Name = isset($_FILES["image2"]["tmp_name"]) ? basename($_FILES["image2"]["name"]) : "";
        $image3Name = isset($_FILES["image3"]["tmp_name"]) ? basename($_FILES["image3"]["name"]) : "";
        
        
        
        $connexion = new mysqli($host_name, $user_name, $password, $database);
        if ($connexion->connect_error) {
            die("Échec de la connexion à la base de données : " . $connexion->connect_error);
        }

        $insertQuery = "INSERT INTO voitures (nom_v, prix, image1, image2, image3, annee, kilometrage) VALUES ('$nom', '$prix', '$image1Name', '$image2Name', '$image3Name', '$annee', '$kilometrage')";
        if ($connexion->query($insertQuery) === TRUE) {
            // Redirection vers la page précédente après un traitement réussi
            echo '<script>window.history.back();</script>';
        } else {
            echo "Erreur lors de l'insertion des données dans la base de données : " . $connexion->error;
        }

        $connexion->close();
    }
}
?>
