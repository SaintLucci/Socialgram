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
if(isset($_SESSION['id'])){
    if(isset($_GET['id_c'])){
        $id_post=$_GET['id_p'];
        $id_comment=$_GET['id_c'];
        $sql = "SELECT * FROM comments WHERE id='$id_comment'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            echo "<div class=\"card big_card_w_opacity\" style='margin-top: 3%;margin-left: 30%;margin-right: 30%'>
        <div class=\"card-body\">";
            echo "<form action='modify_comm_confirmed.php' method='POST'>
        <input type='hidden' value='$id_comment' name='id_comment'>
        <input type='hidden' value='$id_post' name='id_post'>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"newComm\" placeholder='Commento' maxlength=\"1024\" style='margin-bottom: 15px'>";
            echo "<input type='submit' value='Conferma'>
        </form>";
            echo "</div>
        </div>";

        }else{
            echo "<h4>Errore anomalo</h4>";
        }
    }else if($_GET['id_e']){
        $id_post=$_GET['id_p'];
        $id_comment=$_GET['id_e'];
        $sql="SELECT id FROM comments WHERE id='$id_comment'";
        $res=$conn->query($sql);
        if($res->num_rows>0){
            $sqlDel="DELETE FROM comments WHERE id='$id_comment'";
            $resDel=$conn->query($sqlDel);
            $url="comments.php?id_p=";
            header("Location: $url$id_post");
        }
    }
}else{
    echo "<div class=\"card big_card_w_opacity\" style='margin:15%' align='middle'>
  <div class=\"card-body\">";
    echo "<h2 style='color: white'><a href='../users/login.html' style='color: white'>Accedi</a> oppure <a href='../users/register.html' style='color: white'>registrati</a></h2>";
    echo "</div>
</div>";
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
            crossorigin='anonymous'></script>
</body>
</html>";