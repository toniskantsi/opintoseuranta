<?php require_once "header.php";?>

<div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="card bg-light mt-5">
                    <div class="card-title bg-primary text-white mt-5">
                        <h3 class="text-center py-2">Kirjaudu sisään</h3>
                    </div>

                    <?php
                        if(isset($_GET['usercreated'])) {                         // Jos rekisteröinti onnistuu niin siirtyy login sivulle ja tämä viesti näytetään
                          $usercreated=$_GET['usercreated'];
                          $usercreated="Uusi käyttäjä luotu!";                    // Tulostetaan ilmoitus

                    ?>
                        <div class="alert alert-success text-center"><?php echo $usercreated?></div>
                    <?php
                        }
                    ?>
                    <?php
                        if(isset($_GET['missinginfo'])) {                        // Jos käyttäjä jättää kirjautumislomakkeessa jotain tyhjäksi niin...
                          $missinginfo=$_GET['missinginfo'];
                          $missinginfo="Muista täyttää kaikki kentät!";         // Tulostetaan ilmoitus

                    ?>
                        <div class="alert alert-danger text-center"><?php echo $missinginfo?></div>
                    <?php
                        }
                    ?>
                    <?php
                        if(isset($_GET['usernotfound'])) {                      // Jos käyttäjätunnusta ei löydy tietokannasta niin...
                          $usernotfound=$_GET['usernotfound'];
                          $usernotfound="Väärä käyttäjätunnus tai salasana!";   // Tulostetaan ilmoitus

                    ?>
                        <div class="alert alert-danger text-center"><?php echo $usernotfound?></div>
                    <?php
                        }
                    ?>
                    <?php
                        if(isset($_GET['wrongpassword'])) {                     // Jos salasana on väärä niin...
                          $wrongpassword=$_GET['wrongpassword'];
                          $wrongpassword="Väärä käyttäjätunnus tai salasana!";  // Tulostetaan ilmoitus   

                    ?>
                        <div class="alert alert-danger text-center"><?php echo $wrongpassword?></div>
                    <?php
                        }
                    ?>
                    <div class="card-body">
                        
                        <form action="login_action_page.php" method="post">     <!-- Kirjaudu sisään valikko, käsitellään login_action_page.php sivulla -->
                            <input type="email" name="email" placeholder="Syötä sähköpostiosoite" class="form-control my-2">
                            <input type="password" name="password" placeholder="Syötä salasana" class="form-control my-2">
                            <button class="btn btn-success" name="login" class="pt-3">Kirjaudu sisään</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

