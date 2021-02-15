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
      <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Cerca persona\" aria-label=\"Search\" name='search_name' required>
      <button class=\"btn btn-outline-light\" type=\"submit\">Cerca</button>
    </form>
    </nav>";
if(isset($_SESSION['id'])){
    $id_sesh=$_SESSION['id'];
    $sql="SELECT * FROM users WHERE id=$id_sesh";
    $res=$conn->query($sql);
    if($res->num_rows>0){
        while($row=$res->fetch_assoc()){
            $name=$row['name'];
            $surname=$row['surname'];
            $email=$row['email'];
            $gender=$row['gender'];
            $dob=$row['dob'];
        }
    }
    echo "<form action='confirmed_modified_profile.php' enctype=\"multipart/form-data\" method=POST>
    <div class=\"card big_card_w_opacity\" style=\"margin-top:5%;margin-left: 30%;margin-right: 30%\">
        <div class=\"card-body\">
            <h1 style=\"color: white\">Modifica</h1>\
            <input class=\"form-control form-control-sm\" style=\"margin-bottom: 15px;\" type=\"text\" name=\"name\" value=\"$name\"  maxlength=\"128\" minlength=\"1\">
            <input class=\"form-control form-control-sm\" style=\"margin-bottom: 15px;\" type=\"text\" name=\"surname\" value=\"$surname\"  maxlength=\"128\" minlength=\"1\">
            <input class=\"form-control form-control-sm\" style=\"margin-bottom: 15px;\" type=\"email\" name=\"email\" value=\"$email\" maxlength=\"128\" minlength=\"5\">
            <div class=\"form-check\" style=\"color: white\">
                <input class=\"form-check-input\" type=\"radio\" name=\"gender\" id=\"exampleRadios1\" value=\"male\" checked>
                <label class=\"form-check-label\" for=\"exampleRadios1\">
                    Uomo
                </label>
            </div>
            <div class=\"form-check\" style=\"margin-bottom: 15px;color: white\">
                <input class=\"form-check-input\" type=\"radio\" name=\"gender\" id=\"exampleRadios2\" value=\"female\">
                <label class=\"form-check-label\" for=\"exampleRadios2\">
                    Donna
                </label>
            </div>
            <input class=\"form-control form-control-sm\" style=\"margin-bottom: 15px;\" value='$dob' type=\"date\" name=\"dob\">
            <input class=\"form-control form-control-sm\" style=\"margin-bottom: 15px\" type=\"password\" placeholder='Password' name=\"password\" maxlength=\"128\" minlength=\"5\" required>
            <input type=\"submit\" class=\"btn btn-outline-light\" value=\"Modifica dati\">
            </form><br><br>
            <h4 style='color: white'>Immagine del profilo:</h4><input type='file' class='form-control-file' style='color: white' id='exampleFormControlFile1' name='file' accept='image/jpeg, image/png'><br>
            <input type='submit' name='img' value='Cambia immagine' class='btn btn-outline-light'><br><br>
            
            <form action='delete_profile.php' method='post'>
            <button type=\"button\" class=\"btn btn-outline-light float-right\" data-toggle=\"modal\" data-target=\"#exampleModal\">
          Elimina profilo
        </button>
        
        <!-- Modal -->
        <div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
          <div class=\"modal-dialog\" role=\"document\">
            <div class=\"modal-content big_card_w_opacity\" style='color: white'>
              <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"exampleModalLabel\">Sei sicuro di voler eliminare il tuo profilo?</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                  <span aria-hidden=\"true\">&times;</span>
                </button>
              </div>
              <div class=\"modal-body\">
                Se elimini il tuo profilo, tutti i tuoi dati e tutti tuoi post verranno eliminati immediatamente.
              </div>
              <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-outline-light\" data-dismiss=\"modal\">Chiudi</button>
                <button type=\"submit\" class=\"btn btn-outline-light\">Conferma</button>
              </div>
            </div>
          </div>
        </div>
                </div>
            </div>
            </form>
    ";
}else{
    echo "<div class=\"card big_card_w_opacity\" style='margin:15%' align='middle'>
  <div class=\"card-body\">";
    echo "<h2 style='color: white'><a href='../../users/login.html' style='color: white'>Accedi</a> oppure <a href='../../users/register.html' style='color: white'>registrati</a></h2>";
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