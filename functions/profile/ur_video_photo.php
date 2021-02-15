<?php
include '../../db_connect.php';
include '../../functionP.php';
session_start();
ListFilesP('../../uploads');
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
      <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Cerca persona\" aria-label=\"Search\" name='search_name' required>
      <button class=\"btn btn-outline-light\" type=\"submit\">Cerca</button>
    </form>
    </nav>";
echo "<div class=\"card big_card_w_opacity border-light\">
  <div class=\"card-body\">";
if (isset($_SESSION['id'])) {
    if (isset($_GET['id_p'])) {
        $idProfile = $_GET['id_p'];
        echo "<div class='container-fluid'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        echo "<h4 style='color: white;'>I tuoi post: <br></h4>";
        $url = "../comments.php?id_p=";
        foreach (ListFilesP('../../uploads') as $key => $file) {
            list($dir_0, $dir_1, $dir_2, $dir_id, $dir_4) = explode("/", $file);
            if ($dir_4 != "img_profile") {
                list($name_file, $extension) = explode(".", $dir_4);
                if ($dir_id === $idProfile) {
                    $sql = "SELECT * FROM users WHERE id='$dir_id'";
                    $res = $conn->query($sql);
                    $row = $res->fetch_assoc();
                    $name = $row['name'];
                    $sqlDesc = "SELECT * FROM post WHERE id='$name_file'";
                    $resDesc = $conn->query($sqlDesc);
                    $rowDesc = $resDesc->fetch_assoc();
                    $descr = $rowDesc['description'];
                    if ($extension == "jpeg" || $extension == "png") {
                        echo "<div class='' align='middle'>";
                        //echo "<img src=\"$file\" class=\"card-img-top avoid-clicks p_img_container\" alt=\"photo\" style='float: left'>";
                        echo "<div class=\"card mb-3 float-left margin1\">
            <img src=\"$file\" class=\"card-img-top avoid-clicks p_img_container\" alt=\"photo\">
            <div class=\"card-body\">
            <p class=\"card-text\">$descr</p>
            <div class=\"btn-group\">";
                        echo "<button type=\"button\" class=\"btn btn-secondary btn-sm dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            Avanzate
          </button>
          <div class=\"dropdown-menu dropdown-menu-right dropdown-menu-lg-right\">
            <a class=\"dropdown-item\" href='delete_post.php?id_post=$name_file&file_dir=$file'>Elimina</a>
            <a class=\"dropdown-item\" href='modify_post.php?id_post=$name_file'>Modifica descrizione</a>
          </div>";
                        echo "</div>
            </div>
            <a href='$url$name_file'>Visualizza i commenti</a>
            </div>";
                        echo "</div>";
                    } else {
                        echo "<div class='' align='middle'>";
                        echo "<div class=\"card mb-3 float-left margin1 video-height\" style=\"width: 18rem;\">
            <video controls width='100%' class=\"rounded\">

        <source src=\"$file\"
        type='video/webm' class='avoid-clicks'>

        <source src=\"$file\"
        type='video/mp4' class='avoid-clicks'>

        <source src=\"$file\"
        type='video/m4v' class='avoid-clicks'>

        <source src=\"$file\"
        type='video/avi' class='avoid-clicks'>

        Sorry, your browser doesn't support embedded videos.
            </video>
            <div class=\"card-body\">
            <p class=\"card-text\">$descr</p>
                    <div class=\"btn-group\">
      <button type=\"button\" class=\"btn btn-secondary btn-sm dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        Avanzate
      </button>";
                        $url_mod="modify_post.php?id_post=";
      echo "<div class=\"dropdown-menu dropdown-menu-right\">
        <a class=\"dropdown-item\" href='delete_post.php?id_post=$name_file'>Elimina</a>
        <a class=\"dropdown-item\" href='$url_mod$name_file'>Modifica descrizione</a>
      </div>
    </div>
            </div>
            <a href='$url$name_file'>Visualizza i commenti</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            }

        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    } else if (isset($_GET['id_u'])) {
        $idUser = $_GET['id_u'];
        echo "<div class='container-fluid'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        echo "<h4 style='color: white'>I suoi post: <br></h4>";
        $url = "../comments.php?id_p=";
        foreach (ListFilesP('../../uploads') as $key => $file) {
            list($dir_0, $dir_1, $dir_2, $dir_id, $dir_4) = explode("/", $file);
            if ($dir_4 != "img_profile") {
                list($name_file, $extension) = explode(".", $dir_4);
                if ($dir_id === $idUser) {
                    $sql = "SELECT * FROM users WHERE id='$dir_id'";
                    $res = $conn->query($sql);
                    $row = $res->fetch_assoc();
                    $name = $row['name'];
                    $sqlDesc = "SELECT * FROM post WHERE id='$name_file'";
                    $resDesc = $conn->query($sqlDesc);
                    $rowDesc = $resDesc->fetch_assoc();
                    $descr = $rowDesc['description'];
                    if ($extension == "jpeg" || $extension == "png") {
                        echo "<div class='' align='middle'>";
                        //echo "<img src=\"$file\" class=\"card-img-top avoid-clicks p_img_container\" alt=\"photo\" style='float: left'>";
                        echo "<div class=\"card mb-3 float-left margin1\">
            <img src=\"$file\" class=\"card-img-top avoid-clicks p_img_container\" alt=\"photo\">
            <div class=\"card-body\">
            <p class=\"card-text\">$descr</p>
            <div class=\"btn-group\">";
                        echo "</div>
            </div>
            <a href='$url$name_file'>Visualizza i commenti</a>
            </div>";
                        echo "</div>";
                    } else {
                        echo "<div class='' align='middle'>";
                        echo "<div class=\"card mb-3 float-left margin1 video-height\" style=\"width: 18rem;\">
            <video controls width='100%' class=\"rounded\">

        <source src=\"$file\"
        type='video/webm' class='avoid-clicks'>

        <source src=\"$file\"
        type='video/mp4' class='avoid-clicks'>

        <source src=\"$file\"
        type='video/m4v' class='avoid-clicks'>

        <source src=\"$file\"
        type='video/avi' class='avoid-clicks'>

        Sorry, your browser doesn't support embedded videos.
            </video>
            <div class=\"card-body\">
            <p class=\"card-text\">$descr</p>
                    <div class=\"btn-group\">
      </div>
            </div>
            <a href='$url$name_file'>Visualizza i commenti</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            }

        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
echo"</div>
</div>";

echo "
<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'
            integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo'
            crossorigin='anonymous'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'
            integrity='sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49'
            crossorigin='anonymous'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js'
            integrity='sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T'
            crossorigin='anonymous'></script>
</body>
</html>";