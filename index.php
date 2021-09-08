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
        
        if(isset($_SESSION['id_player'])) 
        {
            if($pagina == "jogo") include "paginas/jogo.php";
            elseif($pagina == "login") include "paginas/jogo.php";
            elseif($pagina == "cadastrar") include "paginas/cadastrar.php";
            elseif($pagina == "sair") include "paginas/sair.php";
            elseif($pagina == "batalha") include "paginas/batalha.php";
            else include "paginas/jogo.php";

        }
        else{
            if($pagina == "jogo") include "paginas/login.php";
            elseif($pagina == "login") include "paginas/login.php";
            elseif($pagina == "cadastrar") include "paginas/cadastrar.php";
            elseif($pagina == "sair") include "paginas/login.php";
            else include "paginas/login.php";
        }
    }
    else {
        if(isset($_SESSION['id_player'])) include "paginas/jogo.php";
        else include "paginas/login.php";
        }
}
else {
    if(isset($_SESSION['id_player'])) include "paginas/jogo.php";
    else include "paginas/login.php";
    }
?>

</body>
</html>