<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);
$u = $db->getUser($_SESSION["user"]);
if (isset($_POST["submit"])) {
        if (preg_match("/['^£$%&*()}{#~?><>\/,_|=+¬;-]/", $_POST["vorname"])) {
            $invalidchar = 1;
            //echo "vorname";
        } elseif (preg_match("/['^£$%&*()}{#~?\/><>,_|=+¬;-]/", $_POST["nachname"])) {
            $invalidchar = 1;
            //echo "nachname";
        } elseif (preg_match("/['^£$%&*()}{#~?>\/<>,_|=+¬;-]/", $_POST["adresse"])) {
            $invalidchar = 1;
            //echo "adressse";
        } elseif (preg_match("/['^£$%&*()}{#~?>\/<>,_|=+¬;-]/", $_POST["plz"])) {
            $invalidchar = 1;
            //echo "plz";
        } elseif (preg_match("/['^£$%&*()}{#~?>\/<>,_|=+¬;-]/", $_POST["ort"])) {
            $invalidchar = 1;
            //echo "ort";
        } elseif (preg_match("/['^£$%&*()}{#~?>\/<>,_|=+¬;-]/", $_POST["username"])) {
            $invalidchar = 1;
            //echo "username";
        } elseif (preg_match("/['^£$%&*()}{#~?>\/<>,_|=+¬;-]/", $_POST["password"])) {
            $invalidchar = 1;
            //echo "password";
        } elseif (preg_match("/['^£$%&*()}{#~?>\/<>,_|=+¬;-]/", $_POST["email"])) {
            $invalidchar = 1;
            //echo "email";
        } else {
            $invalidchar = 0;
        }






        if ($invalidchar == 1) {
            echo "<script language='JavaScript'>alert('Keine Sonderzeichen' )</script>";
            echo "<script>window.location.href='index.php?menu=EditUser';</script>";

        }
    if ($invalidchar == 0) {
            echo "User updaten";

            //$updatedata = "UPDATE user SET Anrede='$anrede',Vorname='$vorname',Nachname='$nachname',Adresse='$adresse',PLZ='$plz',Ort='$ort',Username='$username',Passwort='$passsword',EMailAdresse='$email' WHERE id = ".$_POST["userid"]." ";
            $user_object = new User($_POST["userid"], $_POST["anrede"], $_POST["vorname"], $_POST["nachname"], $_POST["adresse"], $_POST["plz"], $_POST["ort"], $_POST["username"], $_POST["password"], $_POST["email"], $_POST["email"]);
            $db->updateUser($user_object);
            echo "<script>window.location.href='index.php?menu=EditUser';</script>";
        }
}
//$sql = "SELECT id,anrede,vorname,nachname,adresse,plz,ort,username,passwort,emailadresse FROM user";
//$result = $mysqli->query($sql);


if ($u->get_anrede() == "NULL") {
    $anrede = "";
} else {
    $anrede = $u->get_anrede();
}
if ($u->get_adresse() == "") {
    $adresse = "";
} else {
    $adresse = $u->get_adresse();
}
if ($u->get_plz() == "0") {
    $plz = "";
} else {
    $plz = $u->get_plz();
}
if ($u->get_ort() == "") {
    $ort = "";
} else {
    $ort = $u->get_ort();
}


$old_pw = "";
//set new password
if(isset($_POST["submit_pw"])){
    $old_pw = $_POST["old_password"];
if((password_verify($old_pw,$u->get_password()) == true) || ($old_pw == $u->get_password())){
    $errorMsg4 = "";
    $strength = password_strength($_POST["password"]);
    if($strength[0]=="False_len"){
       $errorMsg0 = "Passwort muss mindestens 8 Zeichen haben";
    }else{
        $errorMsg0 = "";
    }
    if($strength[1]=="False_num"){
        $errorMsg1 = "<br> Passwort muss mindestens eine Nummer zwischen 1 und 9 haben";
    }else{
        $errorMsg1 = "";
    }
    if($strength[2]=="False_let"){
        $errorMsg2 = "<br> Passwort muss mindestens einen kleinen Buchstaben haben";
    }else{
        $errorMsg2 = "";
    }
    if($strength[3]=="False_cap"){
        $errorMsg3 = "<br> Passwort muss mindesten einen Großbuchstsben haben";
    }else{
        $errorMsg3 = "";
    }
    if ((empty($errorMsg0)) && (empty($errorMsg1)) &&  (empty($errorMsg2)) && (empty($errorMsg3))){
        $email=$u->get_emailadresse();
        $anrede = $u->get_anrede();
        $vorname = $u->get_vorname();
        $nachname = $u->get_nachname();
        $adresse = $u->get_adresse();
        $plz = $u->get_plz();
        $ort = $u->get_ort();
        $username = $u->get_username();
        $id = $u->get_id();
        $new_pw = $_POST["password"];

        $user = new User($id, $anrede, $vorname, $nachname, $adresse, $plz, $ort, $username, $new_pw, $email,$email);
        $db->updateUserPW($user);
        echo "<script>window.location.href='index.php?menu=EditUser';</script>";
    }
}
else{
        $errorMsg4 = "Altes Passwort war falsch";
    }
}
if ((!empty($errorMsg0)) || (!empty($errorMsg1)) ||  (!empty($errorMsg2)) || (!empty($errorMsg3)) || (!empty($errorMsg4)))
 { ?>
    <div class='alert alert-danger alert-dismissible'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <?php echo  "$errorMsg0 $errorMsg1 $errorMsg2 $errorMsg3 $errorMsg4"; ?>
    </div>
<?php }
?>

<div class="container">
    <div class="main-login main-center">
        <h1 class="card-title mt-3 text-center">Benutzer <?= $u->get_username() ?> bearbeiten</h1>
        <div class="container formtop col-md-12 col-sm-12">

            <form id="usereditform" method="post">
                <div class="form-group">
                    <label for="anrede" class="cols-sm-2 control-label">Anrede: </label>
                    <div class="form-row">
                        <div class="input-group col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fas fa-venus-mars"></i> </span>
                            </div>
                            <select name="anrede" id="anrede" class="form-control">
                                <?php
                                if ($u->get_anrede() == "Herr") {
                                    echo "<option value='Herr'>Herr</option>";
                                    echo "<option value='Frau'>Frau</option>";
                                    echo "<option value='NULL'>Keine Auswahl</option>";
                                } elseif ($u->get_anrede() == "Frau") {
                                    echo "<option value='Frau'>Frau</option>";
                                    echo "<option value='Herr'>Herr</option>";
                                    echo "<option value='NULL'>Keine Auswahl</option>";
                                } else {
                                    echo "<option value='NULL'>Keine Auswahl</option>";
                                    echo "<option value='Herr'>Herr</option>";
                                    echo "<option value='Frau'>Frau</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="vorname" class="cols-sm-2 control-label">Name: </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-user"></i> </span>
                        </div>
                        <input class="form-control" type="text" name="vorname" id="vorname" placeholder="Vorname"
                               required value="<?= $u->get_vorname() ?>">
                    </div>
                </div>

                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fas fa-user"></i> </span>
                    </div>
                    <input class="form-control" type="text" name="nachname" id="nachname" placeholder="Nachname"
                           required value="<?= $u->get_nachname() ?>">
                </div>
                <hr/>
                <div>
                    <label for="adresse">Adresse: </label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                        </div>
                        <input class="form-control" type="text" id="adresse" name="adresse" placeholder="Straße 123/4"
                               value="<?= $adresse ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6 input-group">
                            <label for="plz">PLZ: </label>
                        </div>
                        <div class="col-md-6 input-group">
                            <label for="ort">Ort: </label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input class="form-control" type="number" id="plz" name="plz" placeholder="PLZ" min="1000"
                                   max="9999" value="<?= $plz ?>">
                        </div>

                        <div class="col-md-6 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-globe"></i></span>
                            </div>
                            <input class="form-control" type="text" id="ort" name="ort" placeholder="Ort"
                                   value="<?= $ort ?>">
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="username" class="cols-sm-2 control-label">Username: </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-user-circle"></i> </span>
                        </div>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                               required="required" value="<?= $u->get_username() ?>">
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label">Password: </label>
                    <div class="input-group">
                        <a href="#newUserPW<?= $u->get_id()?>" class="btn btn-danger btn-block float-left" data-toggle="modal">Passwort ändern</a>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="email" class="cols-sm-2 control-label"> E-Mail-Adresse: </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-envelope"></i> </span>
                        </div>
                        <input class="form-control" type="email" id="email" name="email" placeholder="email@adresse.com"
                               required value="<?= $u->get_emailadresse() ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-row">
                        <div class="form-group col-md-10 col-sm-6 button-modal-left">
                            <input type="reset" class="btn btn-danger" name="submit" value="Zurücksetzen">

                        </div>
                        <div class="form-group col-md-2 col-sm-6">
                            <input type="hidden" name="userid" id="userid" value="<?=  $u->get_id() ?>">
                            <input type="submit" class="btn btn-success" name="submit" value="Ändern">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="newUserPW<?= $u->get_id() ?>" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Passwort ändern</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class=" main-center">
                            <div class="container formtop col-md-12 col-sm-12">

                                <form method="post">
                                    <div class="form-group">
                                        <label for="old_password" class="cols-sm-2 control-label">Altes Passwort: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fas fa-lock"></i> </span>
                                            </div>
                                            <input onkeyup="trigger()" type="password" id="old_password" name="old_password"
                                                   class="form-control" placeholder="Passwort" required="required">
                                            <span class="showBtn">SHOW</span>
                                        </div>
                                        <hr/>
                                        <label for="password" class="cols-sm-2 control-label">Neues Passwort: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fas fa-lock"></i> </span>
                                            </div>
                                            <input onkeyup="trigger()" type="password" id="password" name="password"
                                                   class="form-control" placeholder="Passwort" required="required">
                                            <span class="showBtn">SHOW</span>
                                        </div>
                                        <div class="indicator">
                                            <span class="weak"></span>
                                            <span class="medium"></span>
                                            <span class="strong"></span>
                                        </div>
                                        <div class="text">Your password is too weak</div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fas fa-lock"></i> </span>
                                            </div>
                                            <input type="password" id="confirm_password" name="confirm_password"
                                                   class="form-control" placeholder="Passwort bestätigen"
                                                   required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-danger btn-block" name="submit_pw" value="Passwort ändern">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
<?php




function password_strength($password)
{
    $returnVal_arr = array();
    $returnVal1 = "True_len";
    $returnVal2 = "True_num";
    $returnVal3 = "True_let";
    $returnVal4 = "True_cap";
    $returnVal_arr[0] = $returnVal1;
    $returnVal_arr[1] = $returnVal2;
    $returnVal_arr[2] = $returnVal3;
    $returnVal_arr[3] = $returnVal4;
    $password_length = 8;
    if (strlen($password) < $password_length) {
        $returnVal1 = "False_len";
        $returnVal_arr[0] = $returnVal1;
    }

    if (!preg_match("#[0-9]+#", $password)) {
        $returnVal2 = "False_num";
        $returnVal_arr[1] = $returnVal2;
    }

    if (!preg_match("#[a-z]+#", $password)) {
        $returnVal3 = "False_let";
        $returnVal_arr[2] = $returnVal3;
    }

    if (!preg_match("#[A-Z]+#", $password)) {
        $returnVal4 = "False_cap";
        $returnVal_arr[3] = $returnVal4;
    }


    return $returnVal_arr;

}


?>
<script>
    var password = document.getElementById("password")
        , confirm_password = document.getElementById("confirm_password")
        , old_password = document.getElementById("old_password")
        , old_password2 = document.getElementById("curr_pw");

    function validatePassword() {
        if (password.value !== confirm_password.value) {
            confirm_password.setCustomValidity("Passwort stimmt nicht überein");
        }
        else {
            confirm_password.setCustomValidity('');
        }
    }


    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;


</script>
