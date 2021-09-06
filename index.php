<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel = "stylesheet" href = "visual/css/reset.css">
    <link rel = "stylesheet" href = "visual/css/style.css">
    <script src="js/script.js"></script>
</head>

<body>
    
<?php
if(isset($_GET['pagina'])) 
{
    $pagina = $_GET['pagina'];

    if (!empty($pagina)){
        
        if(isset($_SESSION['usuario'])) 
        {
            if($pagina == "jogo") include "usuario/jogo.php";
            elseif($pagina == "login") include "usuario/jogo.php";
            elseif($pagina == "cadastrar") include "usuario/cadastrar.php";
            elseif($pagina == "sair") include "usuario/sair.php";
            elseif($pagina == "batalha") include "usuario/batalha.php";
            else include "usuario/jogo.php";

        }
        else{
            if($pagina == "jogo") include "usuario/login.php";
            elseif($pagina == "login") include "usuario/login.php";
            elseif($pagina == "cadastrar") include "usuario/cadastrar.php";
            elseif($pagina == "sair") include "usuario/login.php";
            else include "usuario/login.php";
        }
    }
    else {
        if(isset($_SESSION['usuario'])) include "usuario/jogo.php";
        else include "usuario/login.php";
        }
}
else {
    if(isset($_SESSION['usuario'])) include "usuario/jogo.php";
    else include "usuario/login.php";
    }
?>

</body>
</html>