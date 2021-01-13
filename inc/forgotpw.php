<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);


error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

if (isset($_POST["submit"])) {

    if (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["username"])) {
        $invalidchar = 1;
        //echo "username";
    } else {
        $invalidchar = 0;
    }


    $sql = "SELECT emailadresse FROM user";
    $result = $mysqli->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

            if ($_POST["email"] == $row["emailadresse"]) {
                $exist_mail = 0;
                break;
            } else {
                $exist_mail = 1;
            }
        }

    }
    if ($exist_mail == 1) {
        echo "<script language='JavaScript'>alert('Email " . $_POST["email"] . " ist nicht vorhanden' )</script>";
        echo "<script>window.location.href='index.php';</script>";
    }
    if ($invalidchar == 1) {
        echo "<script language='JavaScript'>alert('Keine Sonderzeichen' )</script>";
        echo "<script>window.location.href='index.php';</script>";

    }
    if ($exist_mail == 0 && $invalidchar == 0) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        $user_object = $db->getUserMail($_POST["email"]);

        $email=$user_object->get_emailadresse();
        $anrede = $user_object->get_anrede();
        $vorname = $user_object->get_vorname();
        $nachname = $user_object->get_nachname();
        $adresse = $user_object->get_adresse();
        $plz = $user_object->get_plz();
        $ort = $user_object->get_ort();
        $username = $user_object->get_username();
        $id = $user_object->get_id();
        mail("$email","New password","$randomString");
        $user_object = new User($id, $anrede, $vorname, $nachname, $adresse, $plz, $ort, $username, $randomString, $email, $username);
        $db->updateUserPW($user_object);
        echo "<script>window.location.href='index.php';</script>";
    }
}
?>

<div class="container">
    <div class="main-login main-center">
        <h1 class="card-title mt-3 text-center">Passwort vergessen?</h1>
        <h3 class="mt-3 text-center">Email eingeben</h3>
        <p class="mt-3 text-center">Das neu generierte Passwort wird an die Mail gesendet</p>
        <div class="container formtop col-md-12 col-sm-12">

            <form method="post">
                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label"> E-Mail-Adresse: </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-envelope"></i> </span>
                        </div>
                        <input class="form-control" type="email" id="email" name="email" placeholder="email@adresse.com"
                               required>
                    </div>
                <hr/>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="submit" class="btn btn-success btn-block" name="submit" value="Neues Passwort anfordern">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
