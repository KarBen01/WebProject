<div class="home1">
    <div class="container" style="text-align: center">
        <div class="textblock">
            <h1> Willkommen bei Kara Database</h1>
            <h4>Ihr Platz um sicher Daten zu speichern</h4>
            <?php
            if (!isset($_SESSION["user"])) {
                ?>
                <p>Falls Sie noch keinen Account haben, einfach auf "Registrieren" klicken und sofort loslegen</p>

                <a href="index.php?menu=register" class="btn btn-primary btn-block home-center">Registrieren</a>
                <?php

            }

            ?>

        </div>
    </div>
</div>
