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
        echo "<script>window.location.href='index.php';</script>";

    }
    if ($invalidchar == 0) {
        //echo "User hinzugefügt";

        $user_object = new User(0, $_POST["anrede"], $_POST["vorname"], $_POST["nachname"], $_POST["adresse"], $_POST["plz"], $_POST["ort"], $_POST["username"], $_POST["password"], $_POST["email"], $_POST["email"]);
        $db->registerUser($user_object);
        echo "<script language='JavaScript'>alert('Neuen User hinzugefügt' )</script>";
        echo "<script>window.location.href='index.php?menu=EditUser';</script>";
    }
}
?>

<div class="container">
    <div class="main-login main-center">
        <h1 class="card-title mt-3 text-center">Create Account</h1>
        <div class="container formtop col-md-12 col-sm-12">

            <form method="post">
                <div class="form-group">
                    <label for="anrede" class="cols-sm-2 control-label">Anrede: </label>
                    <div class="form-row">
                        <div class="input-group col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fas fa-venus-mars"></i> </span>
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
                        <input class="form-control" type="text" name="vorname" id="vorname" placeholder="Vorname"
                               required>
                    </div>
                </div>

                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fas fa-user"></i> </span>
                    </div>
                    <input class="form-control" type="text" name="nachname" id="nachname" placeholder="Nachname"
                           required>
                </div>
                <hr/>
                <div>
                    <label for="adresse">Adresse: </label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                        </div>
                        <input class="form-control" type="text" id="adresse" name="adresse" placeholder="Straße 123/4">
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
                                   max="9999">
                        </div>

                        <div class="col-md-6 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-globe"></i></span>
                            </div>
                            <input class="form-control" type="text" id="ort" name="ort" placeholder="Ort">
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
                               required="required">
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label">Password: </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-lock"></i> </span>
                        </div>
                        <input onkeyup="trigger2()" type="password" id="password2" name="password" class="form-control"
                               placeholder="Passwort" required="required">
                        <span class="showBtn2">SHOW</span>
                    </div>
                    <div class="indicator2">
                        <span class="weak2"></span>
                        <span class="medium2"></span>
                        <span class="strong2"></span>
                    </div>
                    <div class="text2">Your password is too weak</div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-lock"></i> </span>
                        </div>
                        <input type="password" id="confirm_password2" name="confirm_password" class="form-control"
                               placeholder="Passwort bestätigen" required="required">
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label"> E-Mail-Adresse: </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-envelope"></i> </span>
                        </div>
                        <input class="form-control" type="email" id="email" name="email" placeholder="email@adresse.com"
                               required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="reset" class="btn btn-danger" name="reset">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="submit" class="btn btn-success" name="submit" value="Hinzufügen">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    const indicator2 = document.querySelector(".indicator2");
    const weak2 = document.querySelector(".weak2");
    const medium2 = document.querySelector(".medium2");
    const strong2 = document.querySelector(".strong2");
    const text2 = document.querySelector(".text2");
    const showBtn2 = document.querySelector(".showBtn2");
    let regExpWeak = /[a-z]/;
    let regExpMedium = /\d+/;
    let regExpStrong = /.[!,@,#,$,%,^,&,*,?,_,~,-,(,),.,]/;
    var password2 = document.getElementById("password2")
        , confirm_password2 = document.getElementById("confirm_password2");

    function trigger2() {
        if (password2.value !== "") {
            indicator2.style.display = "block";
            indicator2.style.display = "flex";
            if (password2.value.length <= 3 && (password2.value.match(regExpWeak) || password2.value.match(regExpMedium) || password2.value.match(regExpStrong))) no = 1;
            if (password2.value.length >= 6 && ((password2.value.match(regExpWeak) && password2.value.match(regExpMedium)) || (password2.value.match(regExpMedium) && password2.value.match(regExpStrong)) || (password2.value.match(regExpWeak) && password2.value.match(regExpStrong)))) no = 2;
            if (password2.value.length >= 6 && password2.value.match(regExpWeak) && password2.value.match(regExpMedium) && password2.value.match(regExpStrong)) no = 3;
            if (no === 1) {
                weak2.classList.add("active2");
                text2.style.display = "block";
                text2.textContent = "Das Passwort ist sehr schwach";
                text2.classList.add("weak2");
            }
            if (no === 2) {
                medium2.classList.add("active2");
                text2.textContent = "Das Passwort ist okay";
                text2.classList.add("medium2");
            } else {
                medium2.classList.remove("active2");
                text2.classList.remove("medium2");
            }
            if (no === 3) {
                weak2.classList.add("active2");
                medium2.classList.add("active2");
                strong2.classList.add("active2");
                text2.textContent = "Das Passwort ist sehr stark";
                text2.classList.add("strong2");
            } else {
                strong2.classList.remove("active2");
                text2.classList.remove("strong2");
            }
            showBtn2.style.display = "block";
            showBtn2.onclick = function () {
                if (password2.type === "password") {
                    password2.type = "text";
                    showBtn2.textContent = "HIDE";
                    showBtn2.style.color = "#23ad5c";
                } else {
                    password2.type = "password";
                    showBtn2.textContent = "SHOW";
                    showBtn2.style.color = "#000";
                }
            }
        } else {
            indicator2.style.display = "none";
            text2.style.display = "none";
            showBtn2.style.display = "none";
        }
    }


    function validatePassword2() {
        if (password2.value !== confirm_password2.value) {
            confirm_password2.setCustomValidity("Passwort stimmt nicht überein");
        } else {
            confirm_password2.setCustomValidity('');
        }
    }

    password2.onchange = validatePassword2;
    confirm_password2.onkeyup = validatePassword2;

</script>
