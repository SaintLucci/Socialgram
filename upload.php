<?php
include 'db_connect.php';
session_start();
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $dir = "uploads/" . $id . "/";
    $desc = $_POST['description'];
    $desc = addslashes($desc);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
        $target_file = $dir . basename($_FILES["file"]["name"]);
        echo $dir . "<br>";
        $name = $_FILES['file']["name"];
        echo $name . "<br>";
        $tmp_name = $_FILES['file']["tmp_name"];
        echo $tmp_name . "<br>";
        $type = $_FILES['file']['type'];
        echo $type;
        if ($_FILES['file']['size'] > 90000000) {
            echo "Il file è troppo grande" . "<br>";
        } else {
            echo "OK dimensione giusta" . "<br>";
            if ($type == 'video/mp4' || $type == 'video/m4v' || $type == 'video/avi') {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo " ok uploadato";
                    $sql = "INSERT INTO videos (file_name, id_uploadedby) VALUES ('$name',$id)";
                    $res = $conn->query($sql);
                    $sql_video = "SELECT id FROM videos WHERE id_uploadedby='$id' AND file_name='$name'";
                    $res_video = $conn->query($sql_video);
                    $row = $res_video->fetch_assoc();
                    $id_video = $row['id'];
                    $sql_photo = "INSERT INTO photos (file_name,id_uploadedby) VALUES ('no-photo',$id)";
                    $res_photo = $conn->query($sql_photo);
                    $sql_search = "SELECT id FROM photos WHERE id_uploadedby='$id'";
                    $res_search = $conn->query($sql_search);
                    $row_search = $res_search->fetch_assoc();
                    $id_photos = $row_search['id'];
                    $sql_post = "INSERT INTO post (id_user,description,id_foto,id_video) VALUES ($id,'$desc',$id_photos,$id_video)";
                    $res_post = $conn->query($sql_post);
                    $sql_rename = "SELECT id FROM post WHERE id_video='$id_video'";
                    $res_rename = $conn->query($sql_rename);
                    $row_rename = $res_rename->fetch_assoc();
                    $id_post = $row_rename['id'];
                    echo $id_post;
                    list($file_type, $file_ext) = explode("/", $type);
                    echo $file_ext;
                    if ($name != $id_post) {
                        rename($dir . $name, $dir . $id_post . "." . $file_ext);
                    }
                    $sql_update="UPDATE videos SET file_name=$id_post WHERE id=$id_video";
                    $res_update=$conn->query($sql_update);
                    header("Location: index.php");
                } else {
                    echo "Errori";
                }
            } else if ($type == 'image/jpeg' || $type == 'image/png') {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo " ok uploadato";
                    $sql = "INSERT INTO photos (file_name, id_uploadedby) VALUES ('$name',$id)";
                    $res = $conn->query($sql);
                    $sql_photos = "SELECT id FROM photos WHERE id_uploadedby='$id' AND file_name='$name'";
                    $res_photos = $conn->query($sql_photos);
                    $row = $res_photos->fetch_assoc();
                    $id_photos = $row['id'];
                    $sql_video = "INSERT INTO videos (file_name,id_uploadedby) VALUES ('no-video',$id)";
                    $res_video = $conn->query($sql_video);
                    $sql_search = "SELECT id FROM videos WHERE id_uploadedby='$id'";
                    $res_search = $conn->query($sql_search);
                    $row_search = $res_search->fetch_assoc();
                    $id_video = $row_search['id'];
                    $sql_post = "INSERT INTO post (id_user,description,id_foto,id_video) VALUES ($id,'$desc',$id_photos,$id_video)";
                    $res_post = $conn->query($sql_post);
                    $sql_rename = "SELECT id FROM post WHERE id_foto='$id_photos'";
                    $res_rename = $conn->query($sql_rename);
                    $row_rename = $res_rename->fetch_assoc();
                    $id_post = $row_rename['id'];
                    echo $id_post;
                    list($file_type, $file_ext) = explode("/", $type);
                    echo $file_ext;
                    if ($name != $id_post) {
                        rename($dir . $name, $dir . $id_post . "." . $file_ext);
                    }
                    $sql_update="UPDATE photos SET file_name=$id_post WHERE id=$id_photos";
                    $res_update=$conn->query($sql_update);
                    header("Location: index.php");
                }
            } else {
                echo "Errori";
            }
        }
    } else {
        $type = $_FILES['file']['type'];
        echo $type;
        $target_file = $dir . basename($_FILES["file"]["name"]);
        echo $dir . "<br>";
        $name = $_FILES['file']["name"];
        $tmp_name = $_FILES['file']["tmp_name"];
        echo $tmp_name . "<br>";
        if ($_FILES['file']['size'] > 9000000) {
            echo "Il file è troppo grande" . "<br>";
        } else {
            echo "OK dimensione giusta" . "<br>";
            if ($type == 'video/mp4' || $type == 'video/m4v' || $type == 'video/avi') {
                $sql = "SELECT * FROM videos WHERE file_name='$name'";
                $res = $conn->query($sql);
                if ($res->num_rows > 0) {
                    echo "Hai già caricato questo video";
                } else {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                        echo " ok uploadato";
                        $sql = "INSERT INTO videos (file_name, id_uploadedby) VALUES ('$name',$id)";
                        $res = $conn->query($sql);
                        $sql_video = "SELECT id FROM videos WHERE id_uploadedby='$id' AND file_name='$name'";
                        $res_video = $conn->query($sql_video);
                        $row = $res_video->fetch_assoc();
                        $id_video = $row['id'];
                        $sql_photo = "INSERT INTO photos (file_name,id_uploadedby) VALUES ('no-photo',$id)";
                        $res_photo = $conn->query($sql_photo);
                        $sql_search = "SELECT id FROM photos WHERE id_uploadedby='$id'";
                        $res_search = $conn->query($sql_search);
                        $row_search = $res_search->fetch_assoc();
                        $id_photos = $row_search['id'];
                        $sql_post = "INSERT INTO post (id_user,description,id_foto,id_video) VALUES ($id,'$desc',$id_photos,$id_video)";
                        $res_post = $conn->query($sql_post);
                        $sql_rename = "SELECT id FROM post WHERE id_video='$id_video'";
                        $res_rename = $conn->query($sql_rename);
                        $row_rename = $res_rename->fetch_assoc();
                        $id_post = $row_rename['id'];
                        echo $id_post;
                        list($file_type, $file_ext) = explode("/", $type);
                        echo $file_ext;
                        if ($name != $id_post) {
                            rename($dir . $name, $dir . $id_post . "." . $file_ext);
                        }
                        $sql_update="UPDATE videos SET file_name=$id_post WHERE id=$id_video";
                        $res_update=$conn->query($sql_update);
                        header("Location: index.php");
                    } else {
                        echo "Errori";
                    }
                }
            } else if ($type == 'image/jpeg' || $type == 'image/png') {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo " ok uploadato";
                    $sql = "INSERT INTO photos (file_name, id_uploadedby) VALUES ('$name',$id)";
                    $res = $conn->query($sql);
                    $sql_photos = "SELECT id FROM photos WHERE id_uploadedby='$id' AND file_name='$name'";
                    $res_photos = $conn->query($sql_photos);
                    $row = $res_photos->fetch_assoc();
                    $id_photos = $row['id'];
                    $sql_video = "INSERT INTO videos (file_name,id_uploadedby) VALUES ('no-video',$id)";
                    $res_video = $conn->query($sql_video);
                    $sql_search = "SELECT id FROM videos WHERE id_uploadedby='$id'";
                    $res_search = $conn->query($sql_search);
                    $row_search = $res_search->fetch_assoc();
                    $id_video = $row_search['id'];
                    $sql_post = "INSERT INTO post (id_user,description,id_foto,id_video) VALUES ($id,'$desc',$id_photos,$id_video)";
                    $res_post = $conn->query($sql_post);
                    $sql_rename = "SELECT id FROM post WHERE id_foto='$id_photos'";
                    $res_rename = $conn->query($sql_rename);
                    $row_rename = $res_rename->fetch_assoc();
                    $id_post = $row_rename['id'];
                    echo $id_post;
                    list($file_type, $file_ext) = explode("/", $type);
                    echo $file_ext;
                    if ($name != $id_post) {
                        rename($dir . $name, $dir . $id_post . "." . $file_ext);
                    }
                    $sql_update="UPDATE photos SET file_name=$id_post WHERE id=$id_photos";
                    $res_update=$conn->query($sql_update);
                    header("Location: index.php");
                } else {
                    echo "Errori";
                }
            }
        }
    }
    if ($_FILES['file']['name'] == null) {
        $sql = "INSERT INTO post (id_user,description) VALUES ($id,'$desc')";
        $res = $conn->query($sql);
        echo "Post pubblicato con successo.";
        header("Location: index.php");
    }
}




/*if(isset($_POST['submit'])){
    $check=getimagesize($_FILES['file']["tmp_name"]);
    if($check !== false){
        echo " File is an image - ". $check['mime']. "." ."<br>";
    }else{
        echo " File is not an image" ."<br>";
    }
}*/

