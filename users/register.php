<?php
include '../db_connect.php';
echo "<!doctype html>
<html lang='en'>
<head>
    <title>Social</title>
    <meta http-equiv='content-type' content='application/xhtml+xml; charset=utf-8'/>
    <meta name='author' content='Les'/>
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'
          integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
          <link href='../css/mine.css' rel='stylesheet'>
    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.6.3/css/all.css\"
          integrity=\"sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/\" crossorigin=\"anonymous\">      
     </head>";
echo "<body class='bg'>";
echo "
    <nav class=\"navbar navbar-light\" style='padding-top: 16px'>
    <a class=\"navbar-brand\" style='color: white' href=\"../index.php\">
    <img src=\"../imgs/logo.png\" style='width: 15%;height:15%;padding-bottom: -15px' class=\"d-inline-block align-top\" alt=\"\" loading=\"lazy\">
        ocialgram
    </a>
    <a href='../about.php' class='btn btn-outline-light'>About</a>
    </nav>";
$name=$_POST['name'];
$name=addslashes($name);
$surname=$_POST['surname'];
$surname=addslashes($surname);
$email=$_POST['email'];
$gender=$_POST['gender'];
$dob=$_POST['dob'];

$password=$_POST['password'];
$password=md5($password);
$sql="SELECT id FROM users WHERE name='$name' AND email='$email' AND psw='$password'";
$res=$conn->query($sql);
if($res->num_rows>0){
    echo "<div class=\"card big_card_w_opacity\" style='margin: 15%' align='middle'>
  <div class=\"card-body\">";
    echo "Utente già registrato";
    echo "</div>
</div>";
}else{
    $sql="INSERT INTO users (name,surname,email,gender,psw,dob,id_role) VALUES ('$name','$surname','$email','$gender','$password','$dob',3)";
    if($conn->query($sql)===TRUE){
        echo "<div class=\"card big_card_w_opacity\" style='margin: 15%' align='middle'>
  <div class=\"card-body\">";
        echo "<h1 style='color: white'>Utente registrato correttamente, effettua il <a href='login.html' style='color: white'>login</a></h1>";
        echo "</div>
    </div>";
    }else{
        echo "<div class=\"card big_card_w_opacity\" style='margin: 15%' align='middle'>
  <div class=\"card-body\">";
        echo "<h1 style='color: white'>\"Error:\".$conn->error</h1>";
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
            crossorigin='anonymous'>
</script>
</body>
</html>";

