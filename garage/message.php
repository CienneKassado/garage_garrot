<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vos messages</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="icon" href="images/garrot.png" type="image/x-icon">
  <link rel="stylesheet" href="message.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light custom-nav">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="navbar-brand" href="accueil_admin.php">
            <img src="images/garrot.png" alt="Logo" class="logo img-fluid" style="max-width: 120px; margin-top: 7px; margin-right: 20px;">
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="accueil_admin.php">Accueil</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="voitures.php">Véhicules d'occasions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inscription.php">Nouvel Employé</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


  <div class="container">
    <h1 class="text-center"> Vos Messages</h1>

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
    // Récupération des messages depuis la table "contacts"
    $query = "SELECT * FROM contacts";
    $result = $connexion->query($query);

    

    // Affichage des messages
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $message = $row['message_con'];
        $nom = $row['nom_con'];
        $prenom = $row['prenom_con'];
        $email = $row['mail_con'];


        echo '<div class="card-body text-center">';
        echo '<h5 class="card-title">' . $nom . ' ' . $prenom . '</h5>';
        echo '<h6 class="card-subtitle mb-2 text-muted">' . $email . '</h6>';
        echo '<p class="card-text">' . $message . '</p>';
        echo '<form action="supprimer_message.php" method="POST" class="delete-form">';
        echo '<input type="hidden" name="message_id" value="' . $row['id_con'] . '">';
        echo '<button type="submit" class="btn btn-danger">Supprimer</button>';
        echo '</form>';
        echo '</div>';
  
        
      }
    } else {
      echo '<p>Aucun message.</p>';
    }
    $connexion->close();
    ?>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
