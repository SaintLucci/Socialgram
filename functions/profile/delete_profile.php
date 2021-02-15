<?php
include '../../db_connect.php';
include '../../functionP.php';
include 'delete_profile_function.php';
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
    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.6.3/css/all.css\"
          integrity = \"sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/\" crossorigin =\"anonymous\" >            

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
echo "<div class=\"card big_card_w_opacity\" style='margin: 10%'>
  <div class=\"card-body\">";
if(isset($_SESSION['id'])){
    $id_profile=$_SESSION['id'];
    $sql="SELECT * FROM users WHERE id=$id_profile";
    $res=$conn->query($sql);
    if($res->num_rows>0){
        $sqlSearchFriends="SELECT * FROM friends WHERE id_user=$id_profile";
        $resSearchFriends=$conn->query($sqlSearchFriends);
        if($resSearchFriends->num_rows>0){
            $sqlDelFriends="DELETE FROM friends WHERE id_user=$id_profile";
            $resDelFriends=$conn->query($sqlDelFriends);
            echo "<h4 style='color: white'>Lista degli amici rimossa</h4><br>";
        }
        $sqlSearchPost="SELECT * FROM post WHERE id_user=$id_profile";
        $resSearchPost=$conn->query($sqlSearchPost);
        if($resSearchPost->num_rows>0){
            $sqlDelPost="DELETE FROM post WHERE id_user=$id_profile";
            $resDelPost=$conn->query($sqlDelPost);
            echo "<h4 style='color: white'>Post eliminati correttamente</h4><br>";
        }
        $sqlSearchVideo="SELECT * FROM videos WHERE id_uploadedby='$id_profile'";
        $resSearchVideo=$conn->query($sqlSearchVideo);
        if($resSearchVideo->num_rows>0){
            $sqlDelVideo="DELETE FROM videos WHERE id_uploadedby=$id_profile";
            $resDelVideo=$conn->query($sqlDelVideo);
            echo "<h4 style='color: white'>Video eliminat correttamente</h4><br>";
        }
        $sqlSearchPhoto="SELECT * FROM photos WHERE id_uploadedby='$id_profile'";
        $resSearchPhoto=$conn->query($sqlSearchPhoto);
        if($resSearchPhoto->num_rows>0){
            $sqlDelPhoto="DELETE FROM photos WHERE id_uploadedby=$id_profile";
            $resDelPhoto=$conn->query($sqlDelPhoto);
            echo "<h4 style='color: white'>Foto eliminati correttamente</h4><br>";
        }
        $sqlSearchComment="SELECT * FROM comments WHERE id_author='$id_profile'";
        $resSearchComment=$conn->query($sqlSearchComment);
        if($resSearchComment->num_rows>0){
            $sqlDelComment="DELETE FROM comments WHERE id_author=$id_profile";
            $resDelComment=$conn->query($sqlDelComment);
            echo "<h4 style='color: white'>Commenti dell'utente eliminati correttamente</h4><br>";
        }
        $sqlDel="DELETE FROM users WHERE id=$id_profile";
        $resDel=$conn->query($sqlDel);
        echo "Utente eliminato correttamente<br>";
        delete_files('../../uploads/'.$id_profile);
        echo "<h4 style='color: white'>Il profilo è stato eliminato definitivamente</h4>";
    }
    session_destroy();
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