<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);
?>
    <div class="container">
        <div class="main-login main-center">
            <h1 class="card-title mt-3 text-center">Suche nach neuen Freunden</h1>
            <p class="mt-3 text-center">Username eingeben und neue Bekanntschaften machen</p>
            <div class="text-center">
                <a href='#addFriend' class='btn btn-secondary' data-toggle='modal'><i class="fas fa-user-plus"></i>
                    Freund
                    hinzufügen</a>
            </div>
        </div>
    </div>
    <div>
    </div>
    <div id="addFriend" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Freund hinzufügen</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <?php
                        //$sql = "SELECT id,anrede,vorname,nachname,adresse,plz,ort,username,passwort,emailadresse FROM user";
                        //$result = $mysqli->query($sql);
                        $result = $db->getUserList();
                        foreach ($result as $u) {
                            $ergebnis = $db->is_requested($_SESSION["user"], $u->get_username(), "pending");
                            $ergebnis2 = $db->is_requested($u->get_username(), $_SESSION["user"], "pending");
                            $friendopt1 = $db->is_requested($_SESSION["user"],$u->get_username(), "accepted");
                            $friendopt2 = $db->is_requested($u->get_username(), $_SESSION["user"], "accepted");
                            if ($friendopt1 == false && $friendopt2 == false) {
                                echo "<tr>";
                                echo "<td>" . $u->get_username() . "</td>";
                                if ($ergebnis == true) {
                                    echo "<td>Requested</td>";
                                } else if ($ergebnis2 == true) {
                                    echo "<td>Dieser User hat ihnen bereits eine Anfrage gesendet ";
                                    echo "<a style='color: limegreen' href='index.php?menu=Friends&acceptfriend=" . $u->get_username() . "'><span><i class='fas fa-check'></i></a></td>";
                                    echo "<td><a style='color: red' href='index.php?menu=Friends&declinefriend=" . $u->get_username() . "'><i class='fas fa-times'></i></a></td>";
                                } else {
                                    echo "<td><a href='index.php?menu=Friends&addfriend=" . $u->get_username() . "' class='btn btn-success '><i class='fas fa-edit' ></i>Anfrage senden</a></td>";
                                }
                                echo "</tr>";
                            }
                        } ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="container">
                        <a class="btn btn-primary btn-block" data-dismiss="modal">
                            Abbrechen </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="main-login main-center">
            <h2 class="card-title mt-3 text-center">Erhaltene Freundschaftsanfragen</h2>
            <table class="table table-striped">
                <?php
                //$sql = "SELECT id,anrede,vorname,nachname,adresse,plz,ort,username,passwort,emailadresse FROM user";
                //$result = $mysqli->query($sql);
                $result = $db->getUserList();
                foreach ($result as $u) {
                    $ergebnis = $db->is_requested($u->get_username(), $_SESSION["user"], "pending");
                    if ($ergebnis == true) {
                        echo "<tr>";
                        echo "<td>" . $u->get_username() . "</td>";
                        echo "<td><a style='color: limegreen' href='index.php?menu=Friends&acceptfriend=" . $u->get_username() . "'><span><i class='fas fa-check'></i></a></td>";
                        echo "<td><a style='color: red' href='index.php?menu=Friends&declinefriend=" . $u->get_username() . "'><i class='fas fa-times'></i></a></td>";
                        echo "</tr>";
                    }
                    else {

                        }
                } ?>
            </table>
        </div>
    </div>
    <div class="container">
        <div class="main-login main-center">
            <h2 class="card-title mt-3 text-center">Freunde</h2>
            <table class="table table-striped">
                <?php
                $result = $db->getUserList();
                foreach ($result as $u) {
                    $friendopt1 = $db->is_requested($_SESSION["user"],$u->get_username(), "accepted");
                    $friendopt2 = $db->is_requested($u->get_username(), $_SESSION["user"], "accepted");

                    if ($friendopt1 == true || $friendopt2 == true) {
                        echo "<tr>";
                        echo "<td>" . $u->get_username() . "</td>";
                        echo "<td><a style='color: red' href='index.php?menu=Friends&declinefriend=" . $u->get_username() . "'><i class='fas fa-times'></i></a></td>";
                        echo "</tr>";
                    } else {
                    }
                } ?>
            </table>
        </div>
    </div>
<?php

if (isset($_GET["addfriend"])) {
    $db->requestFriend($_SESSION["user"], $_GET["addfriend"], "pending");
    echo "<script>window.location.href='index.php?menu=Friends';</script>";
}

if (isset($_GET["acceptfriend"])) {
    $db->acceptFriend($_GET["acceptfriend"], $_SESSION["user"]);
    echo "<script>window.location.href='index.php?menu=Friends';</script>";
}

if (isset($_GET["declinefriend"])) {
    $friendopt1 = $db->is_requested($_SESSION["user"],$_GET["declinefriend"], "accepted");
    $friendopt2 = $db->is_requested($_GET["declinefriend"], $_SESSION["user"], "accepted");
    $friendopt3 = $db->is_requested($_SESSION["user"],$_GET["declinefriend"], "pending");
    $friendopt4 = $db->is_requested($_GET["declinefriend"], $_SESSION["user"], "pending");
    if ($friendopt1 == true || $friendopt3 == true ) {
        $db->declineFriend($_SESSION["user"],$_GET["declinefriend"]);
        echo "<script>window.location.href='index.php?menu=Friends';</script>";
    }
    else if ($friendopt2 == true || $friendopt4 == true) {
        $db->declineFriend($_GET["declinefriend"],$_SESSION["user"]);
        echo "<script>window.location.href='index.php?menu=Friends';</script>";
    }

    //$db->declineFriend($_SESSION["user"]);
    //echo "<script>window.location.href='index.php?menu=Friends';</script>";
}

