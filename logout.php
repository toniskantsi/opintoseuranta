<?php
session_start();                        // Aloitetaan sessio

    if (isset($_GET['logout'])) {       // Jos "kirjaudu ulos" painiketta on painettu
        session_destroy();              // Lopetetaan sessio
        header ("location:index.php");  // Palataan uloskirjautuneena etusivulle
    }

?>