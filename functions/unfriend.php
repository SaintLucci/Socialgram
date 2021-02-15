<?php
include '../db_connect.php';
session_start();
if(isset($_SESSION['id'])){
    $id_sesh=$_SESSION['id'];
    $id_Friend=$_GET['id_f'];
    $sql="SELECT * FROM friends WHERE id_friend=$id_Friend AND id_user=$id_sesh";
    $res=$conn->query($sql);
    if($res->num_rows>0){
        $sqlDel="DELETE FROM friends WHERE id_friend=$id_Friend AND id_user=$id_sesh";
        $resDel=$conn->query($sqlDel);
        $url="profile/profile.php?id_u=";
        header("Location:$url$id_Friend");
    }else{
        echo "<h2 style='color:black'>Errore anomalo</h2>";
    }
}
