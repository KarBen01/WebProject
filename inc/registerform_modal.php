<?php


$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
if (isset($_POST["submit"])) {

    if (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["vorname"])) {
        $invalidchar = 1;
        //echo "vorname";
    } elseif (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["nachname"])) {
        $invalidchar = 1;
        //echo "nachname";
    } elseif (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["adresse"])) {
        $invalidchar = 1;
        //echo "adressse";
    } elseif (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["plz"])) {
        $invalidchar = 1;
        //echo "plz";
    } elseif (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["ort"])) {
        $invalidchar = 1;
        //echo "ort";
    } elseif (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["username"])) {
        $invalidchar = 1;
        //echo "username";
    } elseif (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["password"])) {
        $invalidchar = 1;
        //echo "password";
    } elseif (preg_match("/['^£$%&*()}{#~?><>,_|=+¬;-]/", $_POST["email"])) {
        $invalidchar = 1;
        //echo "email";
    } else {
        $invalidchar = 0;
    }


    $sql = "SELECT username,emailadresse FROM user";
    $result = $mysqli->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

            if ($_POST["username"] == $row["username"]) {
                $exist_username = 1;
                break;
            } elseif ($_POST["email"] == $row["emailadresse"]) {
                $exist_email = 1;
                break;
            } else {
                $exist_username = 0;
                $exist_email = 0;
            }
        }

    }
    if ($exist_username == 1) {
        echo "<script language='JavaScript'>alert('Username " . $_POST["username"] . " ist bereits vorhanden' )</script>";
        echo "<script>window.location.href='index.php?menu=UserAdministration';</script>";
    }
    if ($exist_email == 1) {
        echo "<script language='JavaScript'>alert('E-Mail-Adresse " . $_POST["email"] . " ist bereits vorhanden' )</script>";
        echo "<script>window.location.href='index.php?menu=UserAdministration';</script>";
    }
    if ($invalidchar == 1) {
        echo "<script language='JavaScript'>alert('Keine Sonderzeichen' )</script>";
        echo "<script>window.location.href='index.php?menu=UserAdministration';</script>";

    }
    if ($exist_username == 0 && $exist_email == 0 && $invalidchar == 0) {
        //echo "User hinzugefügt";

        $user_object = new User(0, $_POST["anrede"], $_POST["vorname"], $_POST["nachname"], $_POST["adresse"], $_POST["plz"], $_POST["ort"], $_POST["username"], $_POST["password"], $_POST["email"], $_POST["email"]);
        $db->registerUser($user_object);
        echo "<script language='JavaScript'>alert('Neuen User hinzugefügt' )</script>";
        echo "<script>window.location.href='index.php?menu=UserAdministration';</script>";
    }
}

?>
<div class="container">
    <a href="#newUser" class="btn btn-success btn-block" style="margin-top: 10px" data-toggle="modal"
       data-target="#newUser"><i class="fas fa-user-plus"></i> <span>Neuer User</span></a>
    <div class="row">
        <div class="col-md-12">
            <div class="modal fade" id="newUser">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" ID="closebtn1" data-dismiss="modal">&times;</button>
                            <h2 class="card-title mt-3 text-center">Create Account</h2>
                        </div>
                        <div class="modal-body">
                            <div class="container formtop col-md-12 col-sm-12">
                                <div class="main-login main-center">
                                    <form id="userform" method="post" action="">
                                        <div class="form-group">
                                            <label for="anrede" class="cols-sm-2 control-label">Anrede: </label>
                                            <div class="form-row">
                                                <div class="input-group col-md-8">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> <i
                                                                    class="fas fa-venus-mars"></i> </span>
                                                    </div>
                                                    <select name="anrede" id="anrede" class="form-control">
                                                        <option value="NULL">Keine Auswahl</option>
                                                        <option value="Herr">Herr</option>
                                                        <option value="Frau">Frau</option>
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
                                                       placeholder="Vorname" required>
                                            </div>
                                        </div>

                                        <div class="form-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fas fa-user"></i> </span>
                                            </div>
                                            <input class="form-control" type="text" name="nachname" id="nachname"
                                                   placeholder="Nachname" required>
                                        </div>
                                        <hr/>
                                        <div>
                                            <label for="adresse">Adresse: </label>
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="adresse" name="adresse"
                                                       placeholder="Straße 123/4">
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
                                                        <span class="input-group-text"><i
                                                                    class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input class="form-control" type="number" id="plz" name="plz"
                                                           placeholder="PLZ" min="1000" max="9999">
                                                </div>

                                                <div class="col-md-6 input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                    class="fas fa-globe"></i></span>
                                                    </div>
                                                    <input class="form-control" type="text" id="ort" name="ort"
                                                           placeholder="Ort">
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
                                                <input type="text" id="username" name="username" class="form-control"
                                                       placeholder="Username" required="required">
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="form-group">
                                            <label for="password" class="cols-sm-2 control-label">Password: </label>
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
                                        <hr/>
                                        <div class="form-group">
                                            <label for="password" class="cols-sm-2 control-label">
                                                E-Mail-Adresse: </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> <i
                                                                class="fas fa-envelope"></i> </span>
                                                </div>
                                                <input class="form-control" type="email" id="email" name="email"
                                                       placeholder="email@adresse.com" required>
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
                                                    <input type="submit" class="btn btn-success" name="submit"
                                                           value="Hinzufügen">
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
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#closebtn1').on('click', function () {
            $('#userform').trigger("reset");
            console.log($('#userform'));
            indicator.style.display = "none";
            text.style.display = "none";
            showBtn.style.display = "none";
        })

    });
    $(document).ready(function () {
        $('#closebtn2').on('click', function () {
            $('#userform').trigger("reset");
            console.log($('#userform'));
            indicator.style.display = "none";
            text.style.display = "none";
            showBtn.style.display = "none";
        })

    });

    const indicator = document.querySelector(".indicator");
    const weak = document.querySelector(".weak");
    const medium = document.querySelector(".medium");
    const strong = document.querySelector(".strong");
    const text = document.querySelector(".text");
    const showBtn = document.querySelector(".showBtn");
    let regExpWeak = /[a-z]/;
    let regExpMedium = /\d+/;
    let regExpStrong = /.[!,@,#,$,%,^,&,*,?,_,~,-,(,),.,]/;
    var password = document.getElementById("password")
        , confirm_password = document.getElementById("confirm_password");

    function trigger() {
        if (password.value !== "") {
            indicator.style.display = "block";
            indicator.style.display = "flex";
            if (password.value.length <= 3 && (password.value.match(regExpWeak) || password.value.match(regExpMedium) || password.value.match(regExpStrong))) no = 1;
            if (password.value.length >= 6 && ((password.value.match(regExpWeak) && password.value.match(regExpMedium)) || (password.value.match(regExpMedium) && password.value.match(regExpStrong)) || (password.value.match(regExpWeak) && password.value.match(regExpStrong)))) no = 2;
            if (password.value.length >= 6 && password.value.match(regExpWeak) && password.value.match(regExpMedium) && password.value.match(regExpStrong)) no = 3;
            if (no === 1) {
                weak.classList.add("active");
                text.style.display = "block";
                text.textContent = "Das Passwort ist sehr schwach";
                text.classList.add("weak");
            }
            if (no === 2) {
                medium.classList.add("active");
                text.textContent = "Das Passwort ist okay";
                text.classList.add("medium");
            } else {
                medium.classList.remove("active");
                text.classList.remove("medium");
            }
            if (no === 3) {
                weak.classList.add("active");
                medium.classList.add("active");
                strong.classList.add("active");
                text.textContent = "Das Passwort ist sehr stark";
                text.classList.add("strong");
            } else {
                strong.classList.remove("active");
                text.classList.remove("strong");
            }
            showBtn.style.display = "block";
            showBtn.onclick = function () {
                if (password.type === "password") {
                    password.type = "text";
                    showBtn.textContent = "HIDE";
                    showBtn.style.color = "#23ad5c";
                } else {
                    password.type = "password";
                    showBtn.textContent = "SHOW";
                    showBtn.style.color = "#000";
                }
            }
        } else {
            indicator.style.display = "none";
            text.style.display = "none";
            showBtn.style.display = "none";
        }
    }


    function validatePassword() {
        if (password.value !== confirm_password.value) {
            confirm_password.setCustomValidity("Passwort stimmt nicht überein");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;


</script>
