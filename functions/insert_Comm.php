<?php
include '../db_connect.php';
session_start();
if(isset($_SESSION['id'])){
    $url="comments.php?id_p=";
    $comment=$_POST['comment'];
    $comment=addslashes($comment);
    $id_post=$_POST['id_post'];
    $id_author=$_SESSION['id'];
    $name=$_POST['name_of_id'];
    $surname=$_POST['surname_of_id'];

    $sql="INSERT INTO comments (id_post,id_author,name,surname,comment) VALUES ($id_post,$id_author,'$name','$surname','$comment')";
    $res=$conn->query($sql);
    header('Location:'.$url.$id_post);
}

