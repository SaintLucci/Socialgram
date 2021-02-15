<?php
include 'db_connect.php';
include 'function.php';
session_start();
echo "<!doctype html>
<html lang='en'>
<head>
    <title>Social</title>
    <meta http-equiv='content-type' content='application/xhtml+xml; charset=utf-8'/>
    <meta name='author' content='Les'/>
    <link rel='stylesheet' type='text/css' href='./css/bootstrap.min.css'
          integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
          <link href='css/mine.css' rel='stylesheet'>
    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.6.3/css/all.css\"
          integrity=\"sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/\" crossorigin=\"anonymous\">      
     </head>";
echo "<body class='bg'>";
if (isset($_SESSION['id'])) {
    $id_sesh = $_SESSION['id'];
    $sqlUser = "SELECT * FROM users WHERE id='$id_sesh'";
    $resUser = $conn->query($sqlUser);
    $rowUser = $resUser->fetch_assoc();
    $emailUser = $rowUser['email'];
    $nameUser = $rowUser['name'];
    $surnameUser = $rowUser['surname'];
    $roleUser = $rowUser['id_role'];
    echo "
    <nav class=\"navbar navbar-light\" style='padding-top: 16px'>
    <a class=\"navbar-brand\" style='color: white' href=\"index.php\">
    <img src=\"imgs/logo.png\" style='width: 15%;height:15%;padding-bottom: -15px' class=\"d-inline-block align-top\" alt=\"\" loading=\"lazy\">
        ocialgram
    </a>
    <a href='about.php' class='btn btn-outline-light'>About</a>
    <form class=\"form-inline my-2 my-lg-0 float-left\" action='functions/search.php' method='post'>
      <input class=\"form-control mr-sm-2 \" type=\"search\" placeholder=\"Cerca persona\" aria-label=\"Search\" name='search_name' required>
      <button class=\"btn btn-outline-light\" type=\"submit\">Cerca</button>
    </form>
    </nav>";
    //row profile
    echo "<div class='container-fluid'>
        <div class='row'>";
    echo "<div class='col-md-4'>";
    //echo "<img src=\"missing.jpg\" alt=\"...\" class=\"img-thumbnail img1 rounded mx-auto d-block avoid-clicks\">";
    if ($roleUser === '1') {
        echo "<h4 align='middle' style='color: red;margin-top: 10px'>Admin</h4>";
    }
    if (is_dir("uploads/" . $id_sesh . "/img_profile")) {
        echo "<img src=\"uploads/$id_sesh/img_profile/img.jpg\" class=\"img-thumbnail img_prof rounded mx-auto d-block avoid-clicks\" alt=\"...\"'>";
    } else {
        echo "<img src=\"imgs/missing.jpg\" class=\"img-thumbnail img_prof rounded mx-auto d-block avoid-clicks\" alt=\"...\">";
    }
    echo "<p>
  <a class=\"btn btn-outline-light\" data-toggle=\"collapse\" href=\"#collapseExample\" role=\"button\" aria-expanded=\"false\">
    Profilo
  </a>
  </p>";
    echo "<div class=\"collapse\" id=\"collapseExample\">
  <div class=\"card card-body card-shadow\">";
    $urlP = "functions/profile/profile.php?id_p=";
    echo "<p class=\"display-4 txt1\">Nome: " . $nameUser . " " . $surnameUser . "</p>";
    echo "<p class=\"display-4 txt1\">E-mail: " . $emailUser . "</p><br>";
    echo "<p class=\"display-4 txt1 avanzate\"><a href='$urlP$id_sesh'>Avanzate</a></p>" . "";
    echo "<a href='logout.php' style='padding-top: 10px;font-size: 200%'><i class=\"fas fa-sign-out-alt\" style='width: 40%'></i></a>";
    echo "</div>
    </div>";
    $urlSugg = "functions/profile/profile.php?id_u=";
    echo "<div class=\"card marg1 card-shadow\">
        <div class=\"card-body\">";
    echo "<p class=\"display-4 txt1\">Persone suggerite: </p>";
    $sqlSugg = "SELECT * FROM users WHERE id NOT IN($id_sesh) ORDER BY RAND() LIMIT 4  ";
    $resSugg = $conn->query($sqlSugg);
    if ($resSugg->num_rows > 0) {
        while ($rowSugg = $resSugg->fetch_assoc()) {
            $idSugg = $rowSugg['id'];
            $name = $rowSugg['name'];
            echo "<p class=\"display-4 txt1\"><a href='$urlSugg$idSugg'>$name</a></p>" . "";
        }
    } else {
        echo "Non hai persone suggerite.";
    }
    echo "</div>
        </div>";

    //row post
    echo "</div>";
    echo "<div class='col-md-4' style='text-align: center'>";

    echo "<div class=\"card padd2 card-shadow\" style='margin-top: 20px'>
            <div class=\"card-body\">";
    echo "<p class=\"display-4 txt1\">Pubblica un post:</p> ";
    echo "<form action='upload.php' enctype='multipart/form-data' method='post'>";
    echo "<input class=\"form-control \" type=\"text\" name='description' placeholder=\"A cosa stai pensando?\">";
    echo "<div class=\"input-group mb-3\">
            <div class=\"custom-file\">
            <input type=\"file\" class=\"custom-file-input\" id=\"inputGroupFile02\" name=\"file\" accept=\"image/jpeg, image/png, video/mp4, video/m4v, video/avi\">
            <label class=\"custom-file-label\" for=\"inputGroupFile02\" aria-describedby=\"inputGroupFileAddon02\">Immagine png/jpg o Video mp4/avi</label>
         </div>
         <div class=\"input-group-append\">
          <input type='submit' class=\"input-group-text\" id=\"inputGroupFileAddon02\">
        </div>
        </div>";
    //echo "<textarea name='description' placeholder='A cosa stai pensando?'></textarea><br>
    //Foto/Video <input type='file' name='file' accept='image/jpeg, image/png, video/mp4, video/m4v, video/avi'><br>
    //<input class=\"btn btn-primary\" type=\"submit\" value=\"Submit\">";
    echo "</form>";
    echo "</div>
</div>";
    ListFiles("uploads/");
    $url = "functions/comments.php?id_p=";
    foreach (ListFiles('uploads') as $key => $file) {
        list($dir_0, $dir_id, $dir_1) = explode("/", $file);
        if ($dir_1 != "img_profile") {
            list($name_file, $extension) = explode(".", $dir_1);
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
                echo "<div class=\"card mb-3 card-shadow bg-card border-light\">
                <img src=\"$file\" class=\"card-img-top avoid-clicks\" alt=\"photo\" width=\"40%\" height=\"40%\">
                <div class=\"card-body\">
                <p class=\"card-text\">$descr</p>
                <p class=\"card-text\"><small class=\"text-muted\">Pubblicato da: $name</small></p>
                </div>
                <a href='$url$name_file'>Visualizza i commenti</a>";
                if ($roleUser === '1') {
                    echo "<button type=\"button\" class=\"btn btn-secondary btn-sm dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" style='margin-top: 15px'>
                    Avanzate
                  </button>";
                    $url_mod = "functions/profile/modify_post.php?id_post=";
                    echo "<div class=\"dropdown-menu dropdown-menu-right\">
                    <a class=\"dropdown-item\" href='functions/profile/delete_post.php?id_post=$name_file&file_dir=../../$file'>Elimina</a>
                    <a class=\"dropdown-item\" href='$url_mod$name_file'>Modifica descrizione</a>
                  </div>";
                }
                echo " </div > ";
                echo "</div > ";
            } else {
                echo "<div class='' align = 'middle' > ";
                echo "<div class=\"card mb-3 card-shadow bg-card border-light\">
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
                <p class=\"card-text\"><small class=\"text-muted\">Pubblicato da: $name</small></p>
                </div>
                <a href='$url$name_file'>Visualizza i commenti</a>";
                if ($roleUser === '1') {
                    echo "<button type=\"button\" class=\"btn btn-secondary btn-sm dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" style='margin-top: 15px'>
                    Avanzate
                  </button>";
                    $url_mod = "functions/profile/modify_post.php?id_post=";
                    echo "<div class=\"dropdown-menu dropdown-menu-right\">
                    <a class=\"dropdown-item\" href='functions/profile/delete_post.php?id_post=$name_file&file_dir=$file'>Elimina</a>
                    <a class=\"dropdown-item\" href='$url_mod$name_file'>Modifica descrizione</a>
                  </div>";
                }
                echo "</div>";
            }
        }
    }



    $sql = "SELECT * FROM post WHERE id_video IS NULL && id_foto IS NULL";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $id_post = $row['id'];
            $id_user = $row['id_user'];
            $desc = $row['description'];
            $sql_user = "SELECT name FROM users WHERE id='$id_user'";
            $res_user = $conn->query($sql_user);
            $row = $res_user->fetch_assoc();
            $user = $row['name'];
            echo "<div class=\"card card-shadow padd2 bg-card border-light\">
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
            if ($roleUser === '1') {
                echo "<button type=\"button\" class=\"btn btn-secondary btn-sm dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" style='margin-top: 15px'>
                    Avanzate
                  </button>";
                $url_mod = "functions/profile/modify_post.php?id_post=";
                echo "<div class=\"dropdown-menu dropdown-menu-right\">
                    <a class=\"dropdown-item\" href='functions/profile/delete_post.php?id_post=$id_post'>Elimina</a>
                    <a class=\"dropdown-item\" href='$url_mod$id_post'>Modifica descrizione</a>
                  </div>";
            }
            echo "</div>";
        }
    }
    echo "</div>
            <div class='col-md-4'>";

    echo "</div>
        </div>
    </div>";


} else {
    echo "
    <nav class=\"navbar navbar-light\" style='padding-top: 16px'>
    <a class=\"navbar-brand\" style='color: white' href=\"index.php\">
    <img src=\"imgs/logo.png\" style='width: 15%;height:15%;padding-bottom: -15px' class=\"d-inline-block align-top\" alt=\"\" loading=\"lazy\">
        ocialgram
    </a>
    <a href='about.php' class='btn btn-outline-light'>About</a>
    </nav>";
    echo "<div class=\"card big_card_w_opacity\" style='margin:15%' align='middle'>
  <div class=\"card-body\">";
    echo "<h2 style='color: white'><a href='users/login.html' style='color: white'>Accedi</a> oppure <a href='users/register.html' style='color: white'>registrati</a></h2>";
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
            crossorigin='anonymous'>
</script>
</body>
</html>";


/*$sqlCountid = "SELECT COUNT(id) FROM users";
$resCount = $conn->query($sqlCountid);
while ($row = $resCount->fetch_assoc()) {
    $id = $row['COUNT(id)'];
}
$random = rand(1, $id);

$imageDir = "uploads/" . $random . "/";
$folder_arr= Array();
$imgs_arr = array();
if (file_exists($imageDir) && is_dir($imageDir)) {
    $dir_arr = scandir($imageDir);
    $arr_files = array_diff($dir_arr, array('.', '..'));

    foreach ($arr_files as $file) {
        $file_path = $imageDir . "/" . $file;
        $ext = pathinfo($file_path, PATHINFO_EXTENSION);

        if ($ext == "jpg" || $ext == "png" || $ext == "JPG" || $ext == "PNG") {
            array_push($imgs_arr, $file);
        }
    }
    $count_img_index = count($imgs_arr) - 1;
    for($i=0;$i<$count_img_index;$i++){
        $random_img = $imgs_arr[rand(0, $count_img_index)];
        echo "<img src=" . $imageDir . $random_img . ">";
    }
}*/