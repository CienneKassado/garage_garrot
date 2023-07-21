<?php

// Débogage
error_reporting(E_ALL);
ini_set("display_errors", 1);

$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';
$connexion = new mysqli($host_name, $user_name, $password, $database);


if ($connexion->connect_error) {
  die("Échec de la connexion à la base de données : " . $connexion->connect_error);
}

$sql_horaires = "SELECT jour_semaine, heure_ouverture, heure_fermeture FROM horaires";
$resultat_horaires = $connexion->query($sql_horaires);

$horaires = array();
while ($row_horaires = $resultat_horaires->fetch_assoc()) {
  $jour_semaine = $row_horaires['jour_semaine'];
  $heure_ouverture = $row_horaires['heure_ouverture'];
  $heure_fermeture = $row_horaires['heure_fermeture'];

  if ($heure_ouverture !== null) {
    $heure_ouverture = date('H:i', strtotime($heure_ouverture));
  }
  if ($heure_fermeture !== null) {
    $heure_fermeture = date('H:i', strtotime($heure_fermeture));
  }

  $horaires[$jour_semaine] = array('heure_ouverture' => $heure_ouverture, 'heure_fermeture' => $heure_fermeture);
}


$sql_infos = "SELECT description,image, email, adresse, telephone FROM infos";
$resultat_infos = $connexion->query($sql_infos);
$row_infos = $resultat_infos->fetch_assoc();


$description = $row_infos['description'];
$image = $row_infos['image'];
$email = $row_infos['email'];
$adresse = $row_infos['adresse'];
$telephone = $row_infos['telephone'];


$sql_commentaires = "SELECT nom, notes, commentaires FROM commentaires";
$resultat_commentaires = $connexion->query($sql_commentaires);

// Créer un tableau pour stocker les commentaires
$commentaires = array();
while ($row_commentaire = $resultat_commentaires->fetch_assoc()) {
  $nom_commentaire = $row_commentaire['nom'];
  $notes_commentaire = $row_commentaire['notes'];
  $commentaire_texte = $row_commentaire['commentaires'];

  // Ajouter chaque commentaire au tableau
  $commentaires[] = array(
    'nom' => $nom_commentaire,
    'notes' => $notes_commentaire,
    'commentaire' => $commentaire_texte
  );
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="icon" href="images/garrot.png" type="image/x-icon">
  <link rel="stylesheet" href="accueil.css">
  
</head>

<body>
  <!-- Header -->
  <header class="text-center py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-2">
          <img src="images/garrot.png" alt="Logo" class="logo img-fluid" style="max-width: 100px; margin-top: 7px;">
        </div>
        <div class="col-md-8">
          <h1 class="title">Le Garage de Mr Parrot</h1>
        </div>
        <div class="col-md-2 text-end">
          <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="images/connexion.svg" alt="Connecter" class="connect-svg img-fluid" style="max-width: 60px; margin-top: 7px;">
            </button>
            <div class="dropdown-menu dropdown-menu-end">
              <a class="dropdown-item" href="connexion.php">Se connecter</a>
              <a class="dropdown-item" href="contact.php">Nous contacter</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <!-- Horaires d'ouverture -->
        <div class="horaire-ouverture mt-4 blur-effect">
          <h3>Horaires d'ouverture :</h3>
          <ul class="list-unstyled">
            <?php
            foreach ($horaires as $jour => $horaire) {
              $heure_ouverture = $horaire['heure_ouverture'];
              $heure_fermeture = $horaire['heure_fermeture'];

              echo '<li>' . $jour . ' : ' . $heure_ouverture . ' - ' . $heure_fermeture . '</li>';
            }
            ?>
          </ul>
        </div>

  

      </div>

      <div class="col-md-6">
        <!-- À propos de nous -->
        <div class="a-propos mt-4 text-center blur-effect" style="border: 2px solid black; padding: 10px;">
          <h2 class="mb-4">À propos de nous</h2>
          <br>
          <p><?php echo $description; ?></p>
        </div>
      </div>
    </div>
  </div>

  <hr class="separator-line full-width">

  <div class="row">
    <div class="col-md-12 text-center">
      <h1 class="mt-4 title-services">Services dans le centre</h1>
      <br>

      <div class="d-flex flex-wrap justify-content-center">
        <!-- Boutons des services -->
        <button type="button" class="btn btn-primary btn-lg custom-btn m-2" onclick="window.location.href='voitures.php'">Nos véhicules d'occasions</button>

        <?php
        // Récupérer les services depuis la base de données
        $sql_services = "SELECT id, nom, description FROM services";
        $resultat_services = $connexion->query($sql_services);

        foreach ($resultat_services as $row_service) {
          $service_id = $row_service['id'];
          $service_nom = $row_service['nom'];
          $service_description = $row_service['description'];

          echo '<button type="button" class="btn btn-primary btn-lg custom-btn m-2" data-bs-toggle="modal" data-bs-target="#modalService' . $service_id . '" data-description="' . htmlspecialchars($service_description) . '">' . $service_nom . '</button>';
        }
        ?>
      </div>

      <!-- Modals pour les services -->
      <?php
      $resultat_services->data_seek(0);

      if ($resultat_services->num_rows > 0) {
        while ($row_service = $resultat_services->fetch_assoc()) {
          $service_id = $row_service['id'];
          $service_nom = $row_service['nom'];
          $service_description = $row_service['description'];

          echo '<div class="modal fade" id="modalService' . $service_id . '" tabindex="-1" aria-labelledby="modalServiceLabel' . $service_id . '" aria-hidden="true">';
          echo '<div class="modal-dialog">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="modalServiceLabel' . $service_id . '">' . $service_nom . '</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<p>' . htmlspecialchars($service_description) . '</p>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      }
      ?>
    </div>
  </div>

  <!-- Votre avis-->
  <div class="row formulaire">
    <div class="col-md-6 text-center">
      <h2 class="mt-4">Votre avis nous intéresse</h2>
      <form action="commentaires.php" method="POST">
        <div class="mb-4">
          <label for="nom" class="form-label">Nom :</label>
          <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="mb-4">
          <label for="notes" class="form-label">Notes (sur 5) :</label>
          <input type="number" name="notes" id="notes" class="form-control" min="1" max="5" required>
        </div>
        <div class="mb-4">
          <label for="commentaire" class="form-label">Commentaire :</label>
          <textarea name="commentaire" id="commentaire" class="form-control" rows="2" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Poster</button>
      </form>
    </div>

    <!-- Commentaires -->
    <div class="col-md-6 commentaires">
      <br>
      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php
          // Diviser les commentaires en groupes de 2
          $commentaires_groupes = array_chunk($commentaires, 2);

          // Afficher les commentaires par groupe dans le carousel
          foreach ($commentaires_groupes as $index => $commentaires_groupe) {
            $active_class = $index === 0 ? 'active' : '';

            echo '<div class="carousel-item ' . $active_class . '">';
            echo '<div class="commentaires-groupe">';
            foreach ($commentaires_groupe as $commentaire) {
              $nom_commentaire = $commentaire['nom'];
              $notes_commentaire = $commentaire['notes'];
              $commentaire_texte = $commentaire['commentaire'];

              echo '<div class="commentaire">';
              echo '<div class="row">';
              echo '<div class="col-md-6">';
              echo '<h4>' . htmlspecialchars($nom_commentaire) . '</h4>';
              echo '</div>';
              echo '<div class="col-md-6">';
              if ($notes_commentaire !== null) {
                echo '<p>Note : ' . htmlspecialchars($notes_commentaire) . '/5</p>';
              }
              echo '</div>';
              echo '</div>';
              echo '<p>' . htmlspecialchars($commentaire_texte) . '</p>';
              echo '</div>';
            }
            echo '</div>';
            echo '</div>';
          }
          ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          
        </button>
      </div>
    </div>
  </div>

  <footer class="text-center py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p>Le Garage de Mr Parrot - Tous droits réservés &copy; <?php echo date('Y'); ?></p>
          <p>Contact : <?php echo $email; ?> - Tél : <?php echo $telephone; ?></p>
        </div>
      </div>
    </div>
  </footer>



  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
