<?php

$mysqli = new mysqli('127.0.0.1', 'root', '', 'ue10');
$db = new DB($mysqli);

$user = $_SESSION["user"];
$result = $db->getUserList();

?>
    <div class="container">

        <?php
        foreach ($result as $u) {
            ?>
            <div class="col-md-12">
                <div class="extra-from textsize">
                    <?php
                    $likes = $db->getLikeNumber(1, $u->get_id());
                    $dislikes = $db->getLikeNumber(2, $u->get_id());


                    $userliked = $db->user_liked($user, 1, $u->get_id());
                    $userdisliked = $db->user_liked($user, 2, $u->get_id());

                    echo $u->get_username();


                    ?>
                    <hr/>
                    <form method="post">
                        <div class="row">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fas fa-comments"></i> </span>
                                </div>
                                <input class="form-control" type="text" name="comment" id="comment"
                                       placeholder="Schreiben Sie ein Kommentar">
                                <input type="hidden" name="userid" id="userid" value="<?= $u->get_id() ?>">
                                <button type="submit" class="btn btn-success" name="submit">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                        </div>
                        <hr/>
                        <div style="font-weight: normal">
                            <?php
                            // var_dump($db->getCommentList($u->get_id()));
                            $comments = $db->getCommentList();
                            foreach ($comments as $comment) {
                                if ($comment->get_fileID() == $u->get_id()) {
                                    if ((isset($_GET["editcomment"])) && ($_GET["editcomment"]==$comment->get_commentID())) {
                                        ?><div class="form-group form-inline">
                                            <label><?=$comment->get_comusername()?>:</label>
                                            <input style="background-color: transparent; border: none !important" type="text" name="newcomment" id="newcomment" class="form-control col" value="<?=$comment->get_comment()?>">
                                        <input type="hidden" name="commentid" id="commentid" value="<?= $comment->get_commentID() ?>">
                                        <button type="submit" class="btn btn-success" name="editcomment">
                                            <i class="fas fa-share"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger" name="canceledit">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        </div>
                                        <?php

                                    }
                                    else{
                                    echo "<b>" . $comment->get_comusername() . ": </b> " . $comment->get_comment();
                                    if ($comment->get_comusername() == $user) {
                                        ?>
                                        <div class='float-right'>
                                            <a style='color: #515151' href='#' role='button' id='dropdownMenuLink'
                                               data-toggle='dropdown'>
                                                <i class='fas fa-ellipsis-h'></i></a>
                                            <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
                                                <a class='dropdown-item' href='?menu=Like1&editcomment=<?= $comment->get_commentID() ?>'>Edit</a>
                                                <a class='dropdown-item'
                                                   href='?menu=Like1&deletecomment=<?= $comment->get_commentID() ?>'>Delete</a>
                                            </div>
                                        </div>
                                    <?php }
                                    }
                                    ?>
                                    <hr style='border-top: dashed 2px; color: #d9d9da'/>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <hr/>
                        <div class="row">
                            <?php
                            if ($userliked == 0) {
                                ?>
                                <div class="col-md-2">
                                    <a href='?menu=Like1&like=<?php echo $u->get_id() ?>'>
                                        <i class="far fa-thumbs-up"></i></a>
                                    <?= $likes; ?>
                                </div>
                            <?php } else { ?>
                                <div class="col-md-2">
                                    <a href='?menu=Like1&remlike=<?php echo $u->get_id() ?>'>
                                        <i class="fas fa-thumbs-up"></i></a>
                                    <?= $likes; ?>
                                </div>
                            <?php }
                            if ($userdisliked == 0) {
                                ?>
                                <div class="col-md-2">
                                    <a style="color: red"
                                       href='?menu=Like1&dislike=<?php echo $u->get_id() ?>'>
                                        <i class="far fa-thumbs-down"></i></a>
                                    <?= $dislikes; ?>
                                </div>
                            <?php } else { ?>
                                <div class="col-md-2">
                                    <a style="color: red"
                                       href='?menu=Like1&remdislike=<?php echo $u->get_id() ?>'>
                                        <i class="fas fa-thumbs-down"></i></a>
                                    <?= $dislikes; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            echo "<br>";
        }


        ?>

    </div>
<?php
if (isset($_GET["like"])) {
    $userdisliked = $db->user_liked($user, 2, $_GET["like"]);

    if ($userdisliked == 1) {
        $db->removeLike(2, $_SESSION["user"], $_GET["like"]);
    }
    $db->addLike(1, $_SESSION["user"], $_GET["like"]);
    echo "<script>window.location.href='index.php?menu=Like1';</script>";
}
if (isset($_GET["dislike"])) {
    $userliked = $db->user_liked($user, 1, $_GET["dislike"]);
    if ($userliked == 1) {
        $db->removeLike(1, $_SESSION["user"], $_GET["dislike"]);
    }
    $db->addLike(2, $_SESSION["user"], $_GET["dislike"]);
    echo "<script>window.location.href='index.php?menu=Like1';</script>";
}

if (isset($_GET["remlike"])) {
    $db->removeLike(1, $_SESSION["user"], $_GET["remlike"]);
    echo "<script>window.location.href='index.php?menu=Like1';</script>";
}

if (isset($_GET["remdislike"])) {
    $db->removeLike(2, $_SESSION["user"], $_GET["remdislike"]);
    echo "<script>window.location.href='index.php?menu=Like1';</script>";
}
if (isset($_GET["deletecomment"])) {
    $db->deleteComment($_GET["deletecomment"]);
    echo "<script>window.location.href='index.php?menu=Like1';</script>";
}

if (isset($_POST["editcomment"])) {
    $newcom = $_POST["newcomment"];
    $comid = $_POST["commentid"];
    $db->editComment($comid,$newcom);
    echo "<script>window.location.href='index.php?menu=Like1';</script>";
}
if (isset($_POST["canceledit"])) {
    echo "<script>window.location.href='index.php?menu=Like1';</script>";
}
if (isset($_POST["submit"])) {
    $fileID = $_POST["userid"];
    $comment = $_POST["comment"];
    echo $fileID;
    echo $comment;
    $db->addComment($comment, $_SESSION["user"], $fileID);
    echo "<script>window.location.href='index.php?menu=Like1';</script>";
}

