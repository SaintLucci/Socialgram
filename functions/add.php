<?php
include '../db_connect.php';
session_start();
if(isset($_SESSION['id'])){
    $id_friend=$_POST['id_Friend'];
    $id_user=$_SESSION['id'];
    $name_Friend=$_POST['name_Friend'];
    $sqlCheck="SELECT id FROM friends WHERE id_friend='$id_friend' AND id_user='$id_user'";
    $resCheck=$conn->query($sqlCheck);
    if($resCheck->num_rows>0){
        echo "Hai già $name_Friend come amico";
    }else{
        $sql="INSERT INTO friends (id_friend, id_user) VALUES($id_friend,$id_user)";
        $res=$conn->query($sql);
        echo "Hai aggiunto come amico $name_Friend";
        $url="profile/profile.php?id_u=";
        header("Location:$url$id_friend");
    }

}
