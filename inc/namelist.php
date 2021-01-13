<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">E-Mail-Adressen</th>
        </tr>
        </thead>

<?php
//$sql = "SELECT id,anrede,vorname,nachname,adresse,plz,ort,username,passwort,emailadresse FROM user";
//$result = $mysqli->query($sql);
$result = $db->getUserList();
foreach ($result as $u) {
    echo "<tr>";
    echo "<td>" . $u->get_emailadresse() . "</td>";
    echo "</tr>";
}?>

</table>

