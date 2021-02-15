<?php
include '../db_connect.php';
session_start();
if (isset($_SESSION['id'])) {
    $id_user = $_SESSION['id'];

    $id_post = $_POST['id_post'];
    $id_comment=$_POST['id_comment'];
    $comm = $_POST['newComm'];
    $comm = addslashes($comm);
    $sql = "UPDATE comments SET comment='$comm' WHERE id='$id_comment'";
    $res = $conn->query($sql);
    echo "Commento modificato correttamente";
    $urlP = "comments.php?id_p=";
    header("Location:" . $urlP . $id_post);


}
