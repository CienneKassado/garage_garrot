<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nos voitures</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="voitures.css">
  <link rel="icon" href="images/garrot.png" type="image/x-icon">

</head>
<body>

<header class="text-center py-4">
    <div class="container">
      <div class="row align-items-center">
      <div class="col-md-2">
  <a href="index.php">
    <img src="images/garrot.png" alt="Logo" class="logo img-fluid" style="max-width: 100px; margin-top: 7px;">
  </a>
</div>

        <div class="col-md-8">
          <h1 class="title" style="font-size: 70px; ">Le Garage de Mr Parrot</h1>
        </div>
        <div class="col-md-2 text-end">
          <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"aria-expanded="false">
              <img src="images/connexion.svg" alt="Connecter" class="connect-svg img-fluid"
                style="max-width: 60px; margin-top: 7px;">
            </button>
            <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="connexion.php">Connectez vous</a>
            <a class="dropdown-item" href="contact.php">Contactez nous</a>
            <a class="dropdown-item" href="index.php">Page d'accueil</a>
             
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
<br>

<div class="container text-center">
  <!-- Formulaire de filtres -->
  <form action="voitures.php" method="GET">
    <div class="row mb-3">
      <!-- Champs pour filtrer par prix -->
      <div class="col-md-4">
        <label for="prix_min" class="form-label">Prix minimum</label>
        <input type="number" class="form-control" id="prix_min" name="prix_min" value="<?php echo isset($_GET['prix_min']) ? $_GET['prix_min'] : ''; ?>" min="0">
      </div>
      <div class="col-md-4">
        <label for="prix_max" class="form-label">Prix maximum</label>
        <input type="number" class="form-control" id="prix_max" name="prix_max" value="<?php echo isset($_GET['prix_max']) ? $_GET['prix_max'] : ''; ?>" min="0">
      </div>
      <div class="col-md-4 mt-4">
        <button type="submit" class="btn btn-primary">Filtrer</button>
        <a href="modification_voitures.php" class="btn btn-secondary">Réinitialiser</a>
      </div>
    </div>
    <div class="row mb-3">
      <!-- Champs pour filtrer par kilométrage -->
      <div class="col-md-4">
        <label for="kilometrage_min" class="form-label">Kilométrage minimum</label>
        <input type="number" class="form-control" id="kilometrage_min" name="kilometrage_min" value="<?php echo isset($_GET['kilometrage_min']) ? $_GET['kilometrage_min'] : ''; ?>" min="0">
      </div>
      <div class="col-md-4">
        <label for="kilometrage_max" class="form-label">Kilométrage maximum</label>
        <input type="number" class="form-control" id="kilometrage_max" name="kilometrage_max" value="<?php echo isset($_GET['kilometrage_max']) ? $_GET['kilometrage_max'] : ''; ?>" min="0">
      </div>
      <div class="col-md-4 mt-4">
        <button type="submit" class="btn btn-primary">Filtrer</button>
        <a href="modification_voitures.php" class="btn btn-secondary">Réinitialiser</a>
      </div>
    </div>
    <div class="row mb-3">
      <!-- Champs pour filtrer par année -->
      <div class="col-md-4">
        <label for="annee_min" class="form-label">Année minimum</label>
        <input type="number" class="form-control" id="annee_min" name="annee_min" value="<?php echo isset($_GET['annee_min']) ? $_GET['annee_min'] : ''; ?>" min="0">
      </div>
      <div class="col-md-4">
        <label for="annee_max" class="form-label">Année maximum</label>
        <input type="number" class="form-control" id="annee_max" name="annee_max" value="<?php echo isset($_GET['annee_max']) ? $_GET['annee_max'] : ''; ?>" min="0">
      </div>
      <div class="col-md-4 mt-4">
        <button type="submit" class="btn btn-primary">Filtrer</button>
        <a href="modification_voitures.php" class="btn btn-secondary">Réinitialiser</a>
      </div>
    </div>
  </form>
</div>



<div class="container">
  <div class="row">
    <?php
    $host_name = 'db5013809319.hosting-data.io';
	$database = 'dbs11556871';
	$user_name = 'dbu2118504';
	$password = '13x10y04z';
	$connexion = new mysqli($host_name, $user_name, $password, $database);

   

    $query = "SELECT * FROM voitures";
    $result = $connexion->query($query);

    // Affichage des voitures
    if ($result->num_rows > 0) {
      $carouselIndex = 0; 

      while ($row = $result->fetch_assoc()) {
        $nom = $row['nom_v'];
        $prix = $row['prix'];
        $image = $row['image1'];
        $image2 = $row['image2'];
        $image3 = $row['image3'];
        $annee = $row['annee'];
        $kilometrage = $row['kilometrage'];

        // Vérification des filtres de prix, kilométrage et année
        if (isset($_GET['prix_min']) && $_GET['prix_min'] !== '' && $prix < (float)$_GET['prix_min']) {
          continue; 
        }

        if (isset($_GET['prix_max']) && $_GET['prix_max'] !== '' && $prix > (float)$_GET['prix_max']) {
          continue; 
        }

        if (isset($_GET['kilometrage_min']) && $_GET['kilometrage_min'] !== '' && $kilometrage < (int)$_GET['kilometrage_min']) {
          continue; 
        }

        if (isset($_GET['kilometrage_max']) && $_GET['kilometrage_max'] !== '' && $kilometrage > (int)$_GET['kilometrage_max']) {
          continue; 
        }

        if (isset($_GET['annee_min']) && $_GET['annee_min'] !== '' && $annee < (int)$_GET['annee_min']) {
          continue;
        }

        if (isset($_GET['annee_max']) && $_GET['annee_max'] !== '' && $annee > (int)$_GET['annee_max']) {
          continue; 
        }

        // Affichage des informations de la voiture dans un bloc
        echo '<div class="col-lg-4 col-md-6">';
        echo '<div class="car-block" data-bs-toggle="modal" data-bs-target="#carModal-' . $carouselIndex . '">';
        echo '<img src="images/' . $image . '" alt="Voiture" class="img-fluid">';
        echo '<div class="car-info">';
        echo '<h3 class="car-name">' . $nom . '</h3>';
        echo '<p class="car-price"> ' . $prix . ' € </p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        // Affichage du modal pour la voiture
        echo '<div class="modal fade" id="carModal-' . $carouselIndex . '" tabindex="-1" aria-labelledby="carModalLabel-' . $carouselIndex . '" aria-hidden="true">';
        echo '<div class="modal-dialog modal-dialog-centered">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="carModalLabel-' . $carouselIndex . '">' . $nom . '</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';

        echo '<div class="modal-body">';
        echo '<div id="carousel-' . $carouselIndex . '" class="carousel slide" data-bs-ride="carousel">';
        echo '<div class="carousel-inner">';

        // Afficher l'image 1
        echo '<div class="carousel-item active">';
        echo '<img src="images/' . $image . '" alt="Voiture" class="d-block w-100">';
        echo '</br>';
        echo '</div>';

        // Vérifier si image2 e image3 contient une valeur
        if (!empty($image2)) {
          echo '<div class="carousel-item">';
          echo '<img src="images/' . $image2 . '" alt="Voiture" class="d-block w-100">';
          echo '</div>';
        }
        if (!empty($image3)) {
          echo '<div class="carousel-item">';
          echo '<img src="images/' . $image3 . '" alt="Voiture" class="d-block w-100">';
          echo '</div>';
        }

        echo '</div>';

        // Carousel
        echo '<button class="carousel-control-prev" type="button" data-bs-target="#carousel-' . $carouselIndex . '" data-bs-slide="prev">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Previous</span>';
        echo '</button>';
        echo '<button class="carousel-control-next" type="button" data-bs-target="#carousel-' . $carouselIndex . '" data-bs-slide="next">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Next</span>';
        echo '</button>';

        echo '</div>';
        echo '<p>Année: ' . $annee . '</p>';
        echo '<p>Kilométrage: ' . $kilometrage . '</p>';
        echo '</div>';

        echo '</div>';
        echo '</div>';
        echo '</div>';


        $carouselIndex++;
      }
    } else {
      echo '<div class="col-12">';
      echo '<div class="alert alert-danger" role="alert">Aucune voiture disponible pour le moment.</div>';
      echo '</div>';
      
    }

 
    ?>
  </div>
</div>


<hr class="my-4">

    <!-- Footer -->
    <footer class="text-center py-4">
  <div class="container">
    <?php

   
    $query = "SELECT * FROM infos";
    $result = $connexion->query($query);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
     
      $email = $row['email'];
      $adresse = $row['adresse'];
      $telephone = $row['telephone'];

      echo '<div class="col-md-12  text-center">';
    
      echo '<p>Email: ' . $email . '</p>';
      echo '<p>Adresse: ' . $adresse . '</p>';
      echo '<p>Téléphone: ' . $telephone . '</p>';
      echo '</div>';
 
    }
    $connexion->close();
  
    ?>
  </div>
</footer>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
