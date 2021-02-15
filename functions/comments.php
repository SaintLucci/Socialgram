<?php
include '../db_connect.php';
session_start();
echo "<!doctype html>
<html lang='en'>
<head>
    <title>Social</title>
    <meta http-equiv='content-type' content='application/xhtml+xml; charset=utf-8'/>
    <meta name='author' content='Les'/>
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'
          integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
          <link href='../css/mine.css' rel='stylesheet'>

</head>";
echo "<body class='bg'>";
echo "
    <nav class=\"navbar navbar-light\" style='padding-top: 16px'>
    <a class=\"navbar-brand\" style='color: white' href=\"../index.php\">
    <img src=\"../imgs/logo.png\" style='width: 15%;height:15%;padding-bottom: -15px' class=\"d-inline-block align-top\" alt=\"\" loading=\"lazy\">
        ocialgram
    </a>
    <a href='../about.php' class='btn btn-outline-light'>About</a>
    <form class=\"form-inline my-2 my-lg-0 float-left\" action='../functions/search.php' method='post'>
      <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Cerca persona\" aria-label=\"Search\" name='search_name' required>
      <button class=\"btn btn-outline-light\" type=\"submit\">Cerca</button>
    </form>
    </nav>";
echo "<div class=\"card card-comment border-light\">
  <div class=\"card-body\">";
if (isset($_SESSION['id'])) {
    $id=$_SESSION['id'];
    $id_post = $_GET['id_p'];
    $sql = "SELECT * FROM post WHERE id='$id_post'";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $sqluser = "SELECT * FROM users WHERE id=$id";
    $resuser = $conn->query($sqluser);
    $rowuser = $resuser->fetch_assoc();
    $name = $rowuser['name'];
    $surname = $rowuser['surname'];
    echo "<form action='insert_Comm.php' method='post'>
    <div class=\"form-group c2\">
    <label for=\"exampleFormControlInput1\"></label>
    <input type=\"text\" class=\"form-control\" id=\"exampleFormControlInput1\" placeholder=\"Commento...\" name='comment'>
        </div>
    <input type='hidden' value='$id_post' name='id_post'>
    <input type='hidden' value='$name' name='name_of_id'>
    <input type='hidden' value='$surname' name='surname_of_id'>
    <input type='submit' value='Inserisci' class='btn btn-outline-light'>
    </form>";

    $sqlComments = "SELECT * FROM comments WHERE id_post='$id_post'";
    $urlProfile="profile/profile.php?id_u=";
    $resComments = $conn->query($sqlComments);
    if ($resComments->num_rows > 0) {
        while ($rowComments = $resComments->fetch_assoc()) {
            $id_comment=$rowComments['id'];
            $name = $rowComments['name'];
            $surname =$rowComments['surname'];
            $comment = $rowComments['comment'];
            $id_author=$rowComments['id_author'];
            echo "<br><div class=\"card\">
        <div class=\"card-header\">";
        echo "<h5 class=\"card-title\" style='margin-top: -10px;margin-bottom: -10px;float: left'><a href='$urlProfile$id_author'>$name $surname</a></h5>";
        if($id===$id_author){
            echo "<button type=\"button\" class=\"btn btn-secondary btn-sm dropdown-toggle float-right\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" style='margin-top: -10px;margin-bottom: -10px;'>
                    Modifica
                  </button>";
            $url_mod = "modify_Comm.php?id_c=";
            $url_del="modify_Comm.php?id_e=";
            echo "<div class=\"dropdown-menu dropdown-menu-right\">
                    <a class=\"dropdown-item\" href='$url_del$id_comment&id_p=$id_post'>Elimina</a>
                    <a class=\"dropdown-item\" href='$url_mod$id_comment&id_p=$id_post'>Modifica descrizione</a>
                  </div>";
        }
        echo "</div>
        <div class=\"card-body\">
            <p class=\"card-text\" style='margin-top: -10px;margin-bottom: -10px'>$comment</p>
        </div>
        </div>";
        }
    } else {
        echo "<p style='color: white;'>Non ci sono commenti</p>";
    }

}else{
    echo "<div class=\"card big_card_w_opacity\" style='margin:15%' align='middle'>
  <div class=\"card-body\">";
    echo "<h2 style='color: white'><a href='../users/login.html' style='color: white'>Accedi</a> oppure <a href='../users/register.html' style='color: white'>registrati</a></h2>";
    echo "</div>
</div>";
}
echo "</div>
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
