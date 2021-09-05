
    <?php

    $server = "localhost";
    $user = "root";
    $pass = "";
    $bd = "rpg";

   if ($conexao = mysqli_connect($server,$user,$pass,$bd)); //echo "Conectado";  
   else  echo "erro";
    ?>