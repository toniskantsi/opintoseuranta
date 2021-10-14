<?php require_once "header.php";?>


    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="card bg-light mt-5">
                    <div class="card-title bg-primary text-white mt-5">
                        <h3 class="text-center py-2">Rekisteröidy</h3>
                    </div>

                    <?php
                        if(isset($_GET['emptyinput'])) {                        // Jos rekisteröitymislomakkeessa jättää jotain tyhjäksi niin...
                          $emptyinput=$_GET['emptyinput'];
                          $emptyinput="Muista täyttää kaikki kentät!";          // Tulostetaan ilmoitus

                    ?>
                        <div class="alert alert-danger text-center"><?php echo $emptyinput?></div>
                    <?php
                        }
                    ?>

                    <?php
                        if(isset($_GET['passwordsdontmatch'])) {                // Jos salasanat eivät täsmää niin...
                          $pwddontmatch=$_GET['passwordsdontmatch'];
                          $pwddontmatch="Salasanat eivät täsmää";               // Tulostetaan ilmoitus

                    ?>
                        <div class="alert alert-danger text-center"><?php echo $pwddontmatch?></div>
                    <?php
                        }
                    ?>
                    <?php
                        if(isset($_GET['invalidcharacters'])) {                 // Jos on kiellettyjä merkkejä niin...
                          $invalidcharacters=$_GET['invalidcharacters'];
                          $invalidcharacters="Etu- tai sukunimi sisältää kiellettyjä merkkejä";     // Tulostetaan ilmoitus

                    ?>
                        <div class="alert alert-danger text-center"><?php echo $invalidcharacters?></div>
                    <?php
                        }
                    ?>
                    <?php
                        if(isset($_GET['emailtaken'])) {                        // Jos sähköpostiosoite on jo käytössä niin...
                          $emailtaken=$_GET['emailtaken'];
                          $emailtaken="Sähköpostiosoite on jo käytössä";        // Tulostetaan ilmoitus

                    ?>
                        <div class="alert alert-danger text-center"><?php echo $emailtaken?></div>
                    <?php
                        }
                    ?>
                
                    <div class="card-body">
                        
                        <form action="signup_action_page.php" method="post">    <!-- Lähetetään tiedot signup_action_page.php -->

                            <input type="text" name="firstname" placeholder="Syötä etunimi" class="form-control my-2">  <!-- Lomake johon täytetään käyttäjän tiedot -->
                            <input type="text" name="lastname" placeholder="Syötä sukunimi" class="form-control my-2">
                            <input type="email" name="email" placeholder="Syötä sähköpostiosoite" class="form-control my-2">
                            <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required name="password" title="Täytyy sisältää vähintään yksi iso ja yksi pieni kirjain, yksi numero sekä vähintään 8 merkkiä" placeholder="Syötä salasana" class="form-control my-2">
                            <input type="password" name="passwordrepeat" placeholder="Syötä salasana uudelleen" class="form-control my-2">
                            <button class="btn btn-success" name="register" class="pt-3">Rekisteröidy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
