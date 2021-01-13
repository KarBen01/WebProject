<?php




$cookie_name = "user";
$cookie_timestamp = "timestamp";
$cookie_lifetime = 3600;
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

session_start();
include "utility/DB.class.php";
include "model/User.class.php";
include "model/comment.class.php";
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);
$user_temp = $db->getUser($_SESSION["user"]);
$temp_id = $user_temp->get_id();
//pw für admin 1234

//var_dump($db->getUserList());
//var_dump($db->getUser('Kudi'));
if (isset($_POST["login"])) {
    $loginUsername = $_POST["username"];
    $loginPassword = $_POST["password"];

    $ergebnis = $db->loginUser($loginUsername, $loginPassword);
    if ($ergebnis == true) {
        $d1 = new Datetime("now");
        $dformat= $d1->format('y.m.d G:i');
        $_SESSION["timestamp"] = $dformat;

        if (isset($_POST["rememberme"])) {
            setcookie($cookie_name, $loginUsername, time() + $cookie_lifetime);
            setcookie($cookie_timestamp, $dformat, time() + $cookie_lifetime);
        }

    } else {
        $errorMsg = "Ungültiger Login";
    }
} else if (!isset($_SESSION["user"]) && isset($_COOKIE[$cookie_name])) {
    $_SESSION["user"] = $_COOKIE['user'];
    $_SESSION["timestamp"] = $_COOKIE['timestamp'];
}

if (@$_GET["menu"] == "logout") {
    $db->createUsertimestamp($_SESSION["timestamp"],$temp_id);
    setcookie($cookie_name, "", time() - $cookie_lifetime);
    setcookie($cookie_timestamp, "", time() - $cookie_lifetime);
    unset($_SESSION["user"]);
    unset($_SESSION["timestamp"]);
    session_destroy();

    echo "<script>window.location.href='index.php';</script>";

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kara Database</title>
    <link rel="icon" href="res/img/karaicon.png">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">


    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>

    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="res/css/myCSS.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
            integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
            crossorigin="anonymous"></script>


</head>
<body>
<?php

include "inc/header.php";


if ((@$_GET["menu"] == 'Home') || (empty(@$_GET["menu"]))) {
    if (!empty($_SESSION["user"])) {
        include"inc/uploadfile.php";
    } else {
        include "inc/home.php";
    }
}
if (@$_GET["menu"] == 'EditUser') {
    if (!empty($_SESSION["user"])) {
            include"inc/useredit.php";
    } else {
        include "inc/home.php";
    }
}

if (@$_GET["menu"] == 'Like1') {
    include"inc/like1.php";
}

if (@$_GET["menu"] == 'register') {
    include "inc/registerForm.php";
}
if (@$_GET["menu"] == "reset-password") {
    include "inc/forgotpw.php";
}
if (@$_GET["menu"] == "Impressum") {
    include "inc/impressum.php";
}
if (@$_GET["menu"] == "Hilfe") {
    include "inc/hilfe.php";
}
if (@$_GET["menu"] == "UserAdministration") {
    include "inc/userAdministration.php";
}
if (@$_GET["menu"] == "Namelist") {
    include "inc/namelist.php";
}
if (@$_GET["menu"] == 'Friends') {
    include"inc/friends.php";
}
if (isset($_GET['delete'])) {
    $db->deleteUser($_GET["delete"]);
    // $deleteuser = "DELETE FROM user WHERE id = '".$_GET["delete"]."'";
    // $result = $mysqli->query($deleteuser);
    echo "<script>window.location.href='index.php?menu=UserAdministration';</script>";
}





mysqli_close($mysqli);
?>

</body>
</html>



