<?php
include '../../db_connect.php';
session_start();
if(isset($_SESSION['id'])) {
    $id_user=$_SESSION['id'];
    $sqlRole="SELECT id_role FROM users WHERE id=$id_user";
    $resRole=$conn->query($sqlRole);
    $row=$resRole->fetch_assoc();
    $id_role=$row['id_role'];

    $id_post = $_POST['id_post'];
    $desc=$_POST['newDesc'];
    $desc=addslashes($desc);
    $sql="UPDATE post SET description='$desc' WHERE id='$id_post'";
    $res=$conn->query($sql);
    echo "Descrizione modificata correttamente";
    $urlP="profile.php?id_p=";
    if($id_role!=='1'){
        header("Location:".$urlP.$id_user);
    }else{
        header("Location: ../../index.php");
    }

}
