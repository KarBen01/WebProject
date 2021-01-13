<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);



if(isset($_POST["file_upload"])){
    $filename = $_FILES['userfile']['name'];

    // destination of the file on the server
    $destination = 'uploads\\' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['userfile']['tmp_name'];
    $size = $_FILES['userfile']['size'];
    $username = $_SESSION["user"];

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['userfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO user_files (file, size, username) VALUES ($filename, $size, $username)";
            if (mysqli_query($mysqli, $sql)) {
                echo "File uploaded successfully";
            }
            else{
                echo "Failed to upload file1.";
                echo $filename;
            }
        } else {
            echo "Failed to upload file2.";
            echo $file."<br>";
            echo $filename."<br>";
            echo $destination."<br>";
        }
    }
}

    /*move_uploaded_file($_FILES['userfile']['tmp_name'], $file);
$username = $_SESSION["user"];
echo $file;
$ergebnis = $db->fileUpload($username,$file);
    if ($ergebnis == true) {
        echo "nice";
    }
    else {
        echo  "Ne";
    }
}*/

?>
<div class="col-md-12 padtop">
    <div class="row">
        <div class="col-md-6 extra-from textsize">
            <form enctype="multipart/form-data"  method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="3000000000000" />
                <!-- File auswahl -->
                <div class="form-group">
                    <label for="File" class="textsize">Datei auswählen</label>
                    <input type="file" class="form-control-file" id="File" name="userfile">

                </div>
                <!-- File upload button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-block roundBtn BtnFile" name="file_upload">Datei hochladen</button>
                </div>
            </form>
        </div>
    </div>
</div>