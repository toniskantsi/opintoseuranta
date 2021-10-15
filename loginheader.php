<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bootstrap/bootstrap.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  <title>Opintoseuranta</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary navbar-expand-sm">    <!-- Headerin väri -->
        <div class="container-fluid">
          <a href="teacher_home.php" class="navbar-brand"><h3>Opintoseuranta</h3></a>   <!-- Kirjautuneen opettajan header näkymä -->
          <div class="headername"><?php
if(isset($_SESSION['User'])) {
  echo '<span class="material-icons md-6">
  perm_identity
  </span>';
  echo ucfirst($_SESSION['User']['firstname']). " ";
  echo ucfirst($_SESSION['User']['lastname']);
}?></div>
          <div class="collapse navbar-collapse">
              <ul class="nav navbar ml-auto">
                    
                  <li class="nav-item"><a href="logout.php?logout" class="btn btn-outline-light">Kirjaudu ulos</a></li>   <!-- Kirjaudu ulos painike -->
                  <span class="settings"><li class="nav-item"><a href="settings.php"> <i class="fa fa-gear" style="font-size:24px;color:grey"></i></a></li></span>  <!-- "Hammasratas" painike, klikkaamalla siirtyy settings.php sivulle -->
              </ul>
          </div>
        </div>

    </nav>
</body>
</html>