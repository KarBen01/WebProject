<?php


$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
if (isset($_POST["submit"])) {


    if (preg_match("/['^£$%&*()}{#~?><,_|=+¬;-]/", $_POST["vorname"])) {
        $invalidchar = 1;
        //echo "vorname";
    } elseif (preg_match("/['^£$%&*()}{#~?><,_|=+¬;-]/", $_POST["nachname"])) {
        $invalidchar = 1;
        //echo "nachname";
    } elseif (preg_match("/['^£$%&*()}{#~?><,_|=+¬;-]/", $_POST["adresse"])) {
        $invalidchar = 1;
        //echo "adressse";
    } elseif (preg_match("/['^£$%&*()}{#~?><,_|=+¬;-]/", $_POST["plz"])) {
        $invalidchar = 1;
        //echo "plz";
    } elseif (preg_match("/['^£$%&*()}{#~?><,_|=+¬;-]/", $_POST["ort"])) {
        $invalidchar = 1;
        //echo "ort";
    } elseif (preg_match("/['^£$%&*()}{#~?><,_|=+¬;-]/", $_POST["username"])) {
        $invalidchar = 1;
        //echo "username";
    } elseif (preg_match("/['^£$%&*()}{#~?><,_|=+¬;-]/", $_POST["password"])) {
        $invalidchar = 1;
        //echo "password";
    } elseif (preg_match("/['^£$%&*()}{#~?><,_|=+¬;-]/", $_POST["email"])) {
        $invalidchar = 1;
        //echo "email";
    } else {
        $invalidchar = 0;
    }


    /*echo "Anrede=$anrede <br>";
echo "Vorname=$vorname <br>";
echo "Nachname=$nachname <br>";
echo "Adresse=$adresse <br>";
echo "PLZ=$plz <br>";
echo "Ort=$ort <br>";
echo "Username=$username <br>";
echo "Password=$passsword <br>";
echo "Email=$email <br>";
*/


    if ($invalidchar == 1) {
        echo "<script language='JavaScript'>alert('Keine Sonderzeichen' )</script>";
        echo "<script>window.location.href='index.php?menu=UserAdministration';</script>";

    }
    if ($invalidchar == 0) {
        echo "User updaten";

        //$updatedata = "UPDATE user SET Anrede='$anrede',Vorname='$vorname',Nachname='$nachname',Adresse='$adresse',PLZ='$plz',Ort='$ort',Username='$username',Passwort='$passsword',EMailAdresse='$email' WHERE id = ".$_POST["userid"]." ";
        $user_object = new User($_POST["userid"], $_POST["anrede"], $_POST["vorname"], $_POST["nachname"], $_POST["adresse"], $_POST["plz"], $_POST["ort"], $_POST["username"], $_POST["password"], $_POST["email"], $_POST["email"]);
        $db->updateUser($user_object);
        echo "<script>window.location.href='index.php?menu=UserAdministration';</script>";
    }


}


?>
<table class="table table-striped">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Anrede</th>
        <th scope="col">Vorname</th>
        <th scope="col">Nachname</th>
        <th scope="col">Adresse</th>
        <th scope="col">PLZ</th>
        <th scope="col">Ort</th>
        <th scope="col">Username</th>
        <th scope="col">E-Mail-Adresse</th>

        <th scope="col">Action</th>
    </tr>
    </thead>

    <?php
    //$sql = "SELECT id,anrede,vorname,nachname,adresse,plz,ort,username,passwort,emailadresse FROM user";
    //$result = $mysqli->query($sql);
    $result = $db->getUserList();
    foreach ($result as $u) {

        if ($u->get_anrede() == "NULL") {
            $anrede = "Keine Angabe";
        } else {
            $anrede = $u->get_anrede();
        }
        if ($u->get_adresse() == "") {
            $adresse = "Keine Angabe";
        } else {
            $adresse = $u->get_adresse();
        }
        if ($u->get_plz() == "0") {
            $plz = "Keine Angabe";
        } else {
            $plz = $u->get_plz();
        }
        if ($u->get_ort() == "") {
            $ort = "Keine Angabe";
        } else {
            $ort = $u->get_ort();
        }

        echo "<tr>";
        echo "<td>" . $anrede . "</td>";
        echo "<td>" . $u->get_vorname() . "</td>";
        echo "<td>" . $u->get_nachname() . "</td>";
        echo "<td>" . $adresse . "</td>";
        echo "<td>" . $plz . "</td>";
        echo "<td>" . $ort . "</td>";
        echo "<td>" . $u->get_username() . "</td>";
        echo "<td>" . $u->get_emailadresse() . "</td>";
        echo "<td>
                  <a href='#editUserModal" . $u->get_id() . "' class='edit' data-toggle='modal'><i class='fas fa-edit' data-toggle='tooltip' title='Edit'></i></a>
                  <a href='#deleteUserModal" . $u->get_id() . "' class='delete' data-toggle='modal' ><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete'></i></a>
              </td>";
        echo "</tr>";

        if(isset($_POST["submit_pw"])){
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

            $u = new User($id, $anrede, $vorname, $nachname, $adresse, $plz, $ort, $username, $new_pw, $email, $email);
            $db->updateUserPW($u);
        }


        ?>

        <!-- Modal für delete User -->

        <div id="deleteUserModal<?php echo $u->get_id() ?>" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Benutzer löschen</h4>
                        </div>
                        <div class="modal-body">
                            <p>Wollen Sie wirklich den User <b>"<?php echo $u->get_username() ?>"</b> aus der Datenbank
                                löschen?</p>
                            <p class="text-danger"><small>Diese Aktion kann nicht rückgängig gemacht werden.</small></p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-primary" data-dismiss="modal" value="Abbrechen">
                            <a href='index.php?delete=<?php echo $u->get_id() ?>' class='btn btn-danger float-right'>
                                Löschen </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal für Edit User  -->

        <div class="modal fade" id="editUserModal<?php echo $u->get_id() ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" ID="closebtn1" data-dismiss="modal">&times;</button>
                        <h2 class="card-title mt-3 text-center"><?php echo $u->get_username() ?> bearbeiten</h2>
                    </div>
                    <div class="modal-body">
                        <div class="container formtop col-md-12 col-sm-12">
                            <div class="main-login main-center">
                                <form id="usereditform" method="post">
                                    <div class="form-group">
                                        <label for="anrede" class="cols-sm-2 control-label">Anrede: </label>
                                        <div class="form-row">
                                            <div class="input-group col-md-8">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> <i
                                                                class="fas fa-venus-mars"></i> </span>
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
                                            <input class="form-control" type="text" name="vorname" id="vorname"
                                                   placeholder="Vorname" required
                                                   value="<?php echo $u->get_vorname() ?>">
                                        </div>
                                    </div>

                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fas fa-user"></i> </span>
                                        </div>
                                        <input class="form-control" type="text" name="nachname" id="nachname"
                                               placeholder="Nachname" required value="<?php echo $u->get_nachname() ?>">
                                    </div>
                                    <hr/>
                                    <div>
                                        <label for="adresse">Adresse: </label>
                                        <div class="form-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            </div>
                                            <input class="form-control" type="text" id="adresse" name="adresse"
                                                   placeholder="Straße 123/4" value="<?php echo $u->get_adresse() ?>">
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
                                                <input class="form-control" type="number" id="plz" name="plz"
                                                       placeholder="PLZ" min="1000" max="9999"
                                                       value="<?php echo $u->get_plz() ?>">
                                            </div>

                                            <div class="col-md-6 input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="ort" name="ort"
                                                       placeholder="Ort" value="<?php echo $u->get_ort() ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-group">
                                        <label for="username" class="cols-sm-2 control-label">Username: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i
                                                            class="fas fa-user-circle"></i> </span>
                                            </div>
                                            <input type="text" id="username" name="username" class="form-control"
                                                   placeholder="Username" required="required"
                                                   value="<?php echo $u->get_username() ?>">
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-group">
                                        <label for="email" class="cols-sm-2 control-label"> E-Mail-Adresse: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fas fa-envelope"></i> </span>
                                            </div>
                                            <input class="form-control" type="email" id="email" name="email"
                                                   placeholder="email@adresse.com" required
                                                   value="<?php echo $u->get_emailadresse() ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-row">
                                            <div class="form-group col-md-10 col-sm-6 button-modal-left">
                                                <button type="button" class="btn btn-danger" id="closebtn2"
                                                        data-dismiss="modal">Abbrechen
                                                </button>

                                            </div>
                                            <div class="form-group col-md-2 col-sm-6">
                                                <input type="hidden" name="userid" id="userid"
                                                       value="<?php echo $u->get_id() ?>">
                                                <input type="submit" class="btn btn-success" name="submit"
                                                       value="Ändern">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
    ?>
</table>


