<?php
include '../../db_connect.php';
session_start();
echo "<!doctype html>
<html lang='en'>
<head>
    <title>Social</title>
    <meta http-equiv='content-type' content='application/xhtml+xml; charset=utf-8'/>
    <meta name='author' content='Les'/>
    <link rel='stylesheet' type='text/css' href='../../css/bootstrap.min.css'
          integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
          <link href='../../css/mine.css' rel='stylesheet'>
     </head>";
echo "<body class='bg'>";
echo "
    <nav class=\"navbar navbar-light\" style='padding-top: 16px'>
    <a class=\"navbar-brand\" style='color: white' href=\"../../index.php\">
    <img src=\"../../imgs/logo.png\" style='width: 15%;height:15%;padding-bottom: -15px' class=\"d-inline-block align-top\" alt=\"\" loading=\"lazy\">
        ocialgram
    </a>
    <a href='../../about.php' class='btn btn-outline-light'>About</a>
    <form class=\"form-inline my-2 my-lg-0 float-left\" action='../../functions/search.php' method='post'>
      <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Cerca persona\" aria-label=\"Search\" name='search_name'>
      <button class=\"btn btn-outline-light\" type=\"submit\">Cerca</button>
    </form>
    </nav>";
$url = "profile.php?id_p=";
if (isset($_SESSION['id'])) {
    $id_sesh = $_SESSION['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $psw = $_POST['password'];
    $psw=md5($psw);
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    if (isset($_POST['img'])) {
        $name_file = $_FILES['file']["name"];
        $dir = "../../uploads/" . $id_sesh . "/img_profile/";
        if (!is_dir($dir)) {
            $type = $_FILES['file']['type'];
            mkdir($dir, 0777, true);
            $target_file = $dir . basename($_FILES["file"]["name"]);
            echo $target_file . "<br>";
            if ($_FILES['file']['size'] > 20000000) {
                echo "Il file è troppo grande" . "<br>";
            } else {
                echo "OK dimensione giusta" . "<br>";
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo " ok uploadato";
                    list($file_type, $file_ext) = explode("/", $type);
                    rename($dir . $name_file, $dir . "img" . "." . "jpg");
                } else {
                    echo "Errori";
                }
            }
            header("Location:" . $url . $id_sesh);
        } else {
            $target_file = $dir . basename($_FILES["file"]["name"]);
            $type = $_FILES['file']['type'];
            echo $target_file . "<br>";
            if ($_FILES['file']['size'] > 20000000) {
                echo "Il file è troppo grande" . "<br>";
            } else {
                echo "OK dimensione giusta" . "<br>";
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo " ok uploadato";
                    list($file_type, $file_ext) = explode("/", $type);
                    rename($dir . $name_file, $dir . "img" . "." . "jpg");

                } else {
                    echo "Errori";
                }
            }
        }
        header("Location:" . $url . $id_sesh);
    }else{
        $sql="SELECT * FROM users WHERE id=$id_sesh";
        $res=$conn->query($sql);
        if($res->num_rows>0){
            $sqlUpdate="UPDATE users SET name='$name', surname='$surname', email='$email', psw='$psw', gender='$gender',dob='$dob' WHERE id=$id_sesh";
            $resUpdate=$conn->query($sqlUpdate);
            echo "Dati aggiornati con successo";
            header("Location:" . $url . $id_sesh);
        }else{
            echo "Errore account non trovato prova ad accedere";
        }
    }
}
echo "
<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'
            integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo'
            crossorigin='anonymous'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'
            integrity='sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49'
            crossorigin='anonymous'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js'
            integrity='sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T'
            crossorigin='anonymous'>
     

</script>
</body>
</html>";

