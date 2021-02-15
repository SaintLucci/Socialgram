<?php
include '../../db_connect.php';
include '../../functionP.php';
ListFilesP('../../uploads');
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
if (isset($_SESSION['id'])) {
    $id_sesh = $_SESSION['id'];
    if (isset($_GET['id_u'])) {
        $idSugg = $_GET['id_u'];
        $sql = "SELECT * FROM users WHERE id='$idSugg'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $name = $row['name'];
                $surname = $row['surname'];
                $email = $row['email'];
                $dob = $row['dob'];
                $dob = date("d-m-y", strtotime($dob));
                $gender = $row['gender'];
            }
            echo "<div class=\"jumbotron jumbotron-fluid jumbo_opacity\" style='color: white;margin-top: 7px;padding: 28px'>
          <div class=\"container\">";
            if (is_dir("../../uploads/" . $idSugg . "/img_profile")) {
                echo "<img src=\"../../uploads/$idSugg/img_profile/img.jpg\" class=\"mr-3 img_prof avoid-clicks\" alt=\"...\" style='float: left'>";
            } else {
                echo "<img src=\"../../imgs/missing.jpg\" class=\"mr-3 img_prof\" alt=\"...\" style='float: left;'>";
            }
            if ($gender === "male") {
                echo "<h1 class=\"display-4\">$name $surname <i class=\"fas fa-mars\" style='font-size: 40px'></i></h1>";
            } else {
                echo "<h1 class=\"display-4\">$name $surname <i class=\"fas fa-venus\" style='font-size: 40px'></i></h1>";
            }
            echo "<p class=\"lead\">E-mail: $email</p>
            <p class=\"lead\">Data di nascita: $dob</p>";
            $var=0;
            if ($id_sesh != $idSugg) {
                $sqlFriends = "SELECT id_friend FROM friends WHERE id_user=$id_sesh";
                $resFriends = $conn->query($sqlFriends);
                $urlUnfriend = "../unfriend.php?id_f=";
                if ($resFriends->num_rows > 0) {
                    while ($rowFriends = $resFriends->fetch_assoc()) {
                        $id_Friends = $rowFriends['id_friend'];
                        if ($idSugg === $id_Friends) {
                            echo "<a href='$urlUnfriend$idSugg'><input type='submit' value='Rimuovi amico'></a>";
                            $var=1;
                            break;
                        }else{
                            $var=0;
                        }
                    }
                    if($var===0){
                        echo "<form action='../add.php' method='post'>
                        <input type='submit' value='Aggiungi amico'>
                        <input type='hidden' value='$name' name='name_Friend'>
                        <input type='hidden' value='$idSugg' name='id_Friend'>
                         </form>";
                    }
                }else{
                    echo "<form action='../add.php' method='post'>
                        <input type='submit' value='Aggiungi amico'>
                        <input type='hidden' value='$name' name='name_Friend'>
                        <input type='hidden' value='$idSugg' name='id_Friend'>
                         </form>";
                }
            }
            echo "</div>
        </div>";
            echo "<div class='container-fluid'>
            <div class='row'>";
            echo "<div class='col-md-3'>";
            $urlP = "ur_video_photo.php?id_u=";
            echo "<a href='$urlP$idSugg'>";
            echo "<h4 style='color: white;'>Le sue foto/video:</h4>";
            echo "<div class=\"card card-shadow div-padding color: white;\">
          <div class=\"card-body\">";
            $i = 0;
            foreach (ListFilesP('../../uploads') as $key => $file) {
                list($dir_0, $dir_1, $dir_2, $dir_id, $dir_4) = explode("/", $file);
                if ($dir_id === $idSugg && $i <= 9 && $dir_4 != "img_profile") {
                    list($name_file, $extension) = explode(".", $dir_4);
                    if ($extension == "jpeg" || $extension == "png") {
                        echo "<img src=\"$file\" class=\"avoid-clicks img_mod\" style='float: left' alt=\"photo\">";
                    } else if ($extension == "mp4" || $extension == "avi") {
                        echo "<img src=\"../../imgs/thumbnail.png\" class=\"avoid-clicks img_mod\" style='float: left' alt=\"photo\">";
                    }
                }
            }
            echo "</div>
            </div>";
            echo "</div>
            </a>";
            echo "<div class='col-md-6'>";
            $url = "../comments.php?id_p=";
            $sql = "SELECT * FROM post WHERE id_video IS NULL && id_foto IS NULL && id_user='$idSugg'";
            $res = $conn->query($sql);
            echo "<h4 style='color: white;'>I suoi post:</h4>";
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $id_post = $row['id'];
                    $id_user = $row['id_user'];
                    $desc = $row['description'];
                    $sql_user = "SELECT name FROM users WHERE id='$id_user'";
                    $res_user = $conn->query($sql_user);
                    $row = $res_user->fetch_assoc();
                    $user = $row['name'];
                    echo "<div class=\"card card-shadow thoughts\" style='text-align:center'>
                    <div class=\"card-header\">
                    Pensieri
                    </div>
                    <div class=\"card-body\">
                    <blockquote class=\"blockquote mb-0\">
                    <p>$desc</p>
                    <footer class=\"blockquote-footer\">Pubblicato da<cite title=\"Source Title\"> $user</cite></footer>
                    </blockquote>
                    </div>
                    <a href='$url$id_post'>Visualizza i commenti</a>
            </div>";
                }
            } else {
                echo "<p style='color: white;'>L'utente non ha ancora pubblicato un pensiero.</p>";
            }
            echo "</div>
            <div class='col-md-3'>";
            echo "</div>
            </div>
            </a>";
        } else {
            Echo "Errore : User non trovato";
        }
    } else if (isset($_GET['id_p'])) {
        $idProfile = $_GET['id_p'];
        $sqlProfile = "SELECT * FROM users WHERE id='$idProfile'";
        $resProfile = $conn->query($sqlProfile);
        $rowProfile = $resProfile->fetch_assoc();
        $nameProf = $rowProfile['name'];
        $surnameProf = $rowProfile['surname'];
        $emailProf = $rowProfile['email'];
        $genderProf = $rowProfile['gender'];
        $dobProf = $rowProfile['dob'];
        $dobProf = date("d-m-y", strtotime($dobProf));
        echo "<div class=\"jumbotron jumbotron-fluid jumbo_opacity\" style='color: white;margin-top: 7px;padding: 30px'>
          <div class=\"container\">";
        if (is_dir("../../uploads/" . $idProfile . "/img_profile")) {
            echo "<img src=\"../../uploads/$idProfile/img_profile/img.jpg\" class=\"mr-3 img_prof avoid-clicks\" alt=\"...\" style='float: left;'>";
        } else {
            echo "<img src=\"../../imgs/missing.jpg\" class=\"mr-3 img_prof avoid-clicks\" alt=\"...\" style='float: left;'>";
        }
        if ($genderProf === "male") {
            echo "<h1 class=\"display-4\">$nameProf $surnameProf <i class=\"fas fa-mars\" style='font-size: 40px'></i></h1>";
        } else {
            echo "<h1 class=\"display-4\">$nameProf $surnameProf <i class=\"fas fa-venus\" style='font-size: 40px'></i></h1>";
        }
        echo "<p class=\"lead\">E-mail: $emailProf</p>
            <p class=\"lead\">Data di nascita: $dobProf</p>";
        echo "  <a href='modify_profile.php'><input type='submit' style='margin-top: -15px' value='Modifica profilo'></a>
          </div>
        </div>";
        echo "<div class='container-fluid'>
        <div class='row'>";
        echo "<div class='col-md-3'>";
        $urlP = "ur_video_photo.php?id_p=";
        echo "<a href='$urlP$idProfile'>";
        echo "<h4 style='color: white;'>Le tue foto/video:</h4>";
        echo "<div class=\"card card-shadow div-padding\">
          <div class=\"card-body\">";
        $i = 0;
        foreach (ListFilesP('../../uploads') as $key => $file) {
            list($dir_0, $dir_1, $dir_2, $dir_id, $dir_4) = explode("/", $file);
            if ($dir_id === $idProfile && $i <= 9 && $dir_4 != "img_profile") {
                list($name_file, $extension) = explode(".", $dir_4);
                if ($extension == "jpeg" || $extension == "png") {
                    echo "<img src=\"$file\" class=\"avoid-clicks img_mod\" style='float: left' alt=\"photo\">";
                } else if ($extension == "mp4" || $extension == "avi") {
                    echo "<img src=\"../../imgs/thumbnail.png\" class=\"avoid-clicks img_mod\" style='float: left' alt=\"photo\">";
                }
            }
        }
        echo "</div>
        </div>";
        echo "</a>";
        echo "</div>";
        echo "<div class='col-md-6'>";
        $url = "../comments.php?id_p=";
        $sql = "SELECT * FROM post WHERE id_video IS NULL && id_foto IS NULL && id_user='$idProfile'";
        $res = $conn->query($sql);
        echo "<h4 style='color: white;'>I tuoi post:</h4>";
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $id_post = $row['id'];
                $id_user_p = $row['id_user'];
                $desc = $row['description'];
                $sql_user = "SELECT name FROM users WHERE id='$idProfile'";
                $res_user = $conn->query($sql_user);
                $row = $res_user->fetch_assoc();
                $user = $row['name'];
                echo "<div class=\"card card-shadow thoughts\" style='text-align: center'>
                    <div class=\"card-header\">
                    Pensieri
                    </div>
                    <div class=\"card-body\">
                    <blockquote class=\"blockquote mb-0\">
                    <p>$desc</p>
                    <footer class=\"blockquote-footer\">Pubblicato da<cite title=\"Source Title\"> $user</cite></footer>
                    </blockquote>
                    </div>
                    <a href='$url$id_post'>Visualizza i commenti</a>";
                echo "<button type=\"button\" class=\"btn btn-secondary btn-sm dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" style='margin-top: 15px'>
                    Avanzate
                  </button>";
                $url_mod = "modify_post.php?id_post=";
                echo "<div class=\"dropdown-menu dropdown-menu-right\">
                    <a class=\"dropdown-item\" href='delete_post.php?id_post=$id_post'>Elimina</a>
                    <a class=\"dropdown-item\" href='$url_mod$id_post'>Modifica descrizione</a>
                  </div>";
                echo "</div>";
            }
        } else {
            echo "Non hai ancora pubblicato un pensiero.";
        }
        echo "</div>
            <div class='col-md-3'>";
        echo "<h4 style='color: white;'>I tuoi amici:</h4>";
        echo "<div class=\"card card-shadow\">
          <div class=\"card-body\">";
        $sql = "SELECT id_friend FROM friends WHERE id_user='$idProfile'";
        $res = $conn->query($sql);
        $urlFriend = "profile.php?id_u=";
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $id_friend = $row['id_friend'];
                $sqlFriends = "SELECT * FROM users WHERE id=$id_friend";
                $resFriends = $conn->query($sqlFriends);
                while ($rowFriends = $resFriends->fetch_assoc()) {
                    $friend_name = $rowFriends['name'];
                    $friend_surname = $rowFriends['surname'];
                    echo "<ul class=\"list-group list-group-flush\" style='padding: 0;margin: 0'>";
                    echo "<li class='list-group-item'><a href='$urlFriend$id_friend'>$friend_name $friend_surname</a></li>";
                    echo "</ul>";

                }
            }
        } else {
            echo "Non hai ancora amici";
        }
        echo "</div>
        </div>
        <h4 style='color: white;margin-top: 15px'>I loro pensieri:</h4>";
        $sqlSearchFriend = "SELECT id_friend FROM friends WHERE id_user=$idProfile";
        $resSearchFriend = $conn->query($sqlSearchFriend);
        if ($resSearchFriend->num_rows > 0) {
            while ($rowSearchFriend = $resSearchFriend->fetch_assoc()) {
                $id_friends = $rowSearchFriend['id_friend'];
                $sqlFriendPost = "SELECT * FROM post WHERE id_video IS NULL && id_foto IS NULL && id_user='$id_friends' ORDER BY RAND() LIMIT 5";
                $resFriendPost = $conn->query($sqlFriendPost);
                if ($resFriendPost->num_rows > 0) {
                    while ($rowFriendPost = $resFriendPost->fetch_assoc()) {
                        $idF_post = $rowFriendPost['id'];
                        $idF_user = $rowFriendPost['id_user'];
                        $descF = $rowFriendPost['description'];
                        $sql_user_f = "SELECT name FROM users WHERE id='$idF_user'";
                        $res_user_f = $conn->query($sql_user_f);
                        $row_f = $res_user_f->fetch_assoc();
                        $user_f = $row_f['name'];
                    }
                    echo "<div class=\"card thoughts card-shadow\" style='text-align: center;margin-bottom: 15px'>
                    <div class=\"card-header\">
                    Pensieri
                    </div>
                    <div class=\"card-body\">
                    <blockquote class=\"blockquote mb-0\">
                    <p>$descF</p>
                    <footer class=\"blockquote-footer\">Pubblicato da<cite title=\"Source Title\"> $user_f</cite></footer>
                    </blockquote>
                    </div>
                    <a href='$url$id_post'>Visualizza i commenti</a>
                    </div>";

                }
            }
        }
        echo "</div>
        </div>
        </div>";
    } else {
        echo "<div class=\"card big_card_w_opacity\" style='margin:15%' align='middle'>
  <div class=\"card-body\">";
        echo "<h2 style='color: white'><a href='../../users/login.html' style='color: white'>Accedi</a> oppure <a href='../../users/register.html' style='color: white'>registrati</a></h2>";
        echo "</div>
</div>";
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
            crossorigin='anonymous'></script>
</body>
</html>";


