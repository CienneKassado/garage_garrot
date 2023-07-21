<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

$host_name = 'db5013809319.hosting-data.io';
$database = 'dbs11556871';
$user_name = 'dbu2118504';
$password = '13x10y04z';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $nouveauxHoraires = $_POST['horaires'];
  $connexion = new mysqli($host_name, $user_name, $password, $database);

  if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
  }

  $sqlSuppression = "DELETE FROM horaires";
  $resultatSuppression = $connexion->query($sqlSuppression);

  if ($resultatSuppression === TRUE) {
    // Les nouveaux horaires dans la base de données
    foreach ($nouveauxHoraires as $jour => $horaire) {
      $heure_ouverture = $horaire['heure_ouverture'];
      $heure_fermeture = $horaire['heure_fermeture'];

      // Si les valeurs ne sont pas nulles avant d'utiliser strtotime()
      if ($heure_ouverture !== "") {
        $heure_ouverture = date('H:i', strtotime($heure_ouverture));
      } else {
        $heure_ouverture = null;
      }
      if ($heure_fermeture !== "") {
        $heure_fermeture = date('H:i', strtotime($heure_fermeture));
      } else {
        $heure_fermeture = null;
      }

      $sqlInsertion = "INSERT INTO horaires (jour_semaine, heure_ouverture, heure_fermeture) VALUES ('$jour', '$heure_ouverture', '$heure_fermeture')";
      $resultatInsertion = $connexion->query($sqlInsertion);

      if (!$resultatInsertion) {
        echo "Erreur lors de l'insertion des nouveaux horaires pour le jour " . $jour . ": " . $connexion->error;
      }
    }
  }
}



  $connexion = new mysqli($host_name, $user_name, $password, $database);

if ($connexion->connect_error) {
  die("Échec de la connexion à la base de données : " . $connexion->connect_error);
}

$sql = "SELECT jour_semaine, heure_ouverture, heure_fermeture FROM horaires";
$resultat = $connexion->query($sql);

// Créer un tableau  avec les horaires
$horaires = array();
while ($row = $resultat->fetch_assoc()) {
  $jour_semaine = $row['jour_semaine'];
  $heure_ouverture = $row['heure_ouverture'];
  $heure_fermeture = $row['heure_fermeture'];

  // Vérifier si les valeurs ne sont pas nulles avant d'utiliser strtotime()
  if ($heure_ouverture !== null) {
    $heure_ouverture = date('H:i', strtotime($heure_ouverture));
  }
  if ($heure_fermeture !== null) {
    $heure_fermeture = date('H:i', strtotime($heure_fermeture));
  }

  $horaires[$jour_semaine] = array('heure_ouverture' => $heure_ouverture, 'heure_fermeture' => $heure_fermeture);
}

// Récupérer les informations du garage depuis la base de données
$sql_infos = "SELECT * FROM infos";
$resultat_infos = $connexion->query($sql_infos);


$row_infos = $resultat_infos->fetch_assoc();

$description = $row_infos['description'];
$image = $row_infos['image'];
$email = $row_infos['email'];
$adresse = $row_infos['adresse'];
$telephone = $row_infos['telephone'];

$sql_commentaires = "SELECT * FROM commentaires";
$resultat_commentaires = $connexion->query($sql_commentaires);

$commentaires = array();
while ($row_commentaire = $resultat_commentaires->fetch_assoc()) {
  $id_commentaire = $row_commentaire['id'];
  $nom_commentaire = $row_commentaire['nom'];
  $notes_commentaire = $row_commentaire['notes'];
  $commentaire_texte = $row_commentaire['commentaires'];
 

  $commentaires[] = array(
    'id' => $id_commentaire,
    'nom' => $nom_commentaire,
    'notes' => $notes_commentaire,
    'commentaire' => $commentaire_texte,
    
  );
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil Administrateur</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="accueil.css">
  <link rel="icon" href="images/garrot.png" type="image/x-icon">
  <script src="script.js"></script>


 
</head>

<body>
  <header class="text-center py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-2">
          <img src="images/garrot.png" alt="Logo" class="logo img-fluid" style="max-width: 100px; margin-top: 7px;">
        </div>
        <div class="col-md-8">
          <h1 class="title" style="font-size: 76px; margin-top: 10px;">Le Garage de Mr Parrot</h1>
        </div>
        <div class="col-md-2 text-end">
          <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
              aria-expanded="false">
              <img src="images/connexion.svg" alt="Connecter" class="connect-svg img-fluid"
                style="max-width: 60px; margin-top: 7px;">
            </button>
            <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="index.php">Se déconnecter</a>
              <a class="dropdown-item" href="message.php">Vos messages</a>
              <a class="dropdown-item" href="inscription.php">Inscrire un nouvel employé</a>
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="horaire-ouverture mt-4 blur-effect">
         
          <form action="" method="POST">
            <ul class="list-unstyled">
              <?php
            foreach ($horaires as $jour => $horaire) {
              $heure_ouverture = $horaire['heure_ouverture'];
              $heure_fermeture = $horaire['heure_fermeture'];

              echo '<li>' . $jour . ' : <input type="time" name="horaires[' . $jour . '][heure_ouverture]" value="'
                . $heure_ouverture . '"> - <input type="time" name="horaires[' . $jour . '][heure_fermeture]" value="'
                . $heure_fermeture . '"></li>';
            }
            ?>
            </ul>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </form>
        </div>
</div>

<div class="col-md-6">
        <div class="a-propos mt-4 text-center blur-effect" style="border: 2px solid black; padding: 10px;">
          <h2 class="mb-4">À propos de nous</h2>
          
          <br>
          <p><?php echo $description; ?></p>
        </div>

        <div class="nouveau-service-form mt-4" style="margin-left: 20px; text-align: center;"> <!-- Nouvelle classe pour le formulaire et centrage du texte -->
          <h3>Ajouter un nouveau service</h3> <!-- Ajouter une étiquette pour indiquer l'objectif du formulaire -->
          <form action="ajouter_service.php" method="POST">
            <div class="mb-3">
              <label for="nom" class="form-label">Nom :</label>
              <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description :</label>
              <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
          </form>
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
        <button type="button" class="btn btn-primary btn-lg custom-btn m-2"
          onclick="window.location.href='modification_voitures.php'">Nos véhicules d'occasions</button>

        <?php
       
        $sql_services = "SELECT * FROM services";
        $resultat_services = $connexion->query($sql_services);

        if ($resultat_services->num_rows > 0) {
        while ($row_service = $resultat_services->fetch_assoc()) {
            $service_id = $row_service['id'];
            $service_nom = $row_service['nom'];
            $service_description = $row_service['description'];

            // Afficher le bouton des services
            echo '<button type="button" class="btn btn-primary btn-lg custom-btn m-2" data-bs-toggle="modal" data-bs-target="#modalService' . $service_id . '">' . $service_nom . '</button>';
        }
        }

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
            echo '<h5 class="modal-title" id="modalServiceLabel' . $service_id . '">Modifier le service</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<form action="modification_service.php" method="POST">';
            echo '<input type="hidden" name="service_id" value="' . $service_id . '">';
            echo '<div class="mb-3">';
            echo '<label for="service_nom" class="form-label">Nouveau nom :</label>';
            echo '<input type="text" name="service_nom" class="form-control" value="' . htmlspecialchars($service_nom) . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="service_description" class="form-label">Nouvelle description :</label>';
            echo '<textarea name="service_description" class="form-control" rows="3" required>' . htmlspecialchars($service_description) . '</textarea>';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Enregistrer</button>';
            echo '<button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#modalConfirmation'. $service_id . '">Supprimer ce service </button>';

            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        }
        

      ?>
      </div>
    </div>
  </div>

  <br>

<!-- Votre avis-->

<div class="row formulaire">
    <div class="col-md-6 text-center">
      <h2 class="mt-4">Répondez à vos client</h2>
      <form action="commentaires.php" method="POST">
        <div class="mb-4">
          <label for="nom" class="form-label">Nom :</label>
          <input type="text" name="nom" id="nom" class="form-control" value="LE GARAGE DE Mr Parrot" readonly>
        </div>
        <div class="mb-4">
          <label for="commentaire" class="form-label">Commentaire :</label>
          <textarea name="commentaire" id="commentaire" class="form-control" rows="2" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Poster</button>
      </form>
    </div>

    <div class="col-md-6 commentaires">
  <div id="carouselExampleControls" class="carousel slide text-center" data-bs-ride="carousel">
    <div class="carousel-inner text-center">
      <?php
      // Diviser les commentaires en groupes de 5
      $commentaires_groupes = array_chunk($commentaires, 2);

      // Afficher les commentaires par groupe
      foreach ($commentaires_groupes as $index => $commentaires_groupe) {
        $active_class = $index === 0 ? 'active' : '';

        echo '<div class="carousel-item ' . $active_class . '">';
        echo '<div class="commentaires-groupe">';
        foreach ($commentaires_groupe as $commentaire) {
          $id_commentaire = $commentaire['id'];
          $nom_commentaire = $commentaire['nom'];
          $notes_commentaire = $commentaire['notes'];
          $commentaire_texte = $commentaire['commentaire'];
          

          echo '<div class="commentaire text-center">'; // Ajoutez la classe "text-center" pour centrer le contenu
          echo '<div class="row">';
          echo '<div class="col-md-12">'; // Utilisez une seule colonne pour le titre pour le centrer correctement
          echo '<h4>' . htmlspecialchars($nom_commentaire) . '</h4>';
          echo '</div>';

          echo '<div class="col-md-12">';
          if ($notes_commentaire !== null) {
            echo '<p>Note : ' . htmlspecialchars($notes_commentaire) . '/5</p>';
          }
          echo '</div>';
          echo '</div>';
          echo '<p>' . htmlspecialchars($commentaire_texte) . '</p>';

        
          
          // Bouton "Supprimer" 
          echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmation'
            . $id_commentaire . '">Supprimer</button>';
          echo '</div>';


          // Modal pour la confirmation de suppression 
          echo '<div class="modal fade" id="modalConfirmation' . $id_commentaire
            . '" tabindex="-1" aria-labelledby="modalConfirmationLabel" aria-hidden="true">';
          echo '<div class="modal-dialog">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="modalConfirmationLabel">Confirmation</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo 'Êtes-vous sûr de vouloir supprimer ce commentaire ?';
          echo '</div>';
          echo '<div class="modal-footer">';
          echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>';
          echo '<form action="supprimer_commentaire.php" method="POST" class="delete-form">';
          echo '<input type="hidden" name="commentaire_id" value="' . $id_commentaire . '">';
          echo '<button type="submit" class="btn btn-danger">Supprimer</button>';
          echo '</form>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        echo '</div>';
        echo '</div>';
      }

        $connexion->close();

      ?>


<!-- Modal de confirmation-->

<div class="modal fade" id="modalConfirmation<?php echo $service_id; ?>" tabindex="-1" aria-labelledby="modalConfirmationLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmationLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Êtes-vous sûr de vouloir supprimer ce service ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <form action="supprimer_service.php" method="POST" class="delete-form">
          <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
          <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!--  Fleches pour le carousel-->
   
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </button>
    </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>