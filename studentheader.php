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
    <nav class="navbar navbar-dark bg-primary navbar-expand-sm">
        <div class="container-fluid">
          <a href="student_home.php" class="navbar-brand"><h3>Opintoseuranta</h3></a>
          <div class="headername"><?php
include "connect.php";                              // Ainut keino millä sain oppilaskäyttäjän nimen tulostettua myös edit.php sivulle oli ajaa tässä sama sql ajo kuin student_home.php
$sessio = $_SESSION['User'];                        // Laitetaan sessio muuttujaan
$sql = "SELECT * FROM users WHERE id = $sessio";                        // Valitaan kaikki users taulusta jotka täsmäävät tämän session ID:n kanssa

$result = mysqli_query($conn, $sql);                                    // SQL kysely
$resultCheck = mysqli_num_rows($result);                                // Tarkistetaan montako riviä palautuu kyselystä

if ($resultCheck > 0) {                                                 // Jos tuloksia on yli 0, tee seuraava..
    while ($row = mysqli_fetch_assoc($result)) {                        // Laitetaan tulokset assosiative arrayhin nimeltä $row
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
    }
}
if(isset($_SESSION['User'])) {
  echo '<span class="material-icons md-6">
  perm_identity
  </span>';
  echo ucfirst($firstname). " ";     // sql ajosta saadut etu- ja sukunimi tulostetaan headeriin
  echo ucfirst($lastname);
}?></div>
                  <li class="nav-item"><a href="logout.php?logout" class="btn btn-outline-light">Kirjaudu ulos</a></li>
                  </ul>
          </div>
        </div>

    </nav>
</body>
</html>