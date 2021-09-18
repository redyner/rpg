<?php
session_start();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG</title>
    <link rel = "stylesheet" href = "visual/css/reset.css">
    <link rel = "stylesheet" href = "visual/css/style.css">
    <script src = "js/jquery.js"></script>
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
            if($pagina == "jogo") (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/jogo.php" : include "paginas/criarpersonagem.php";
            elseif($pagina == "login") (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/jogo.php" : include "paginas/criarpersonagem.php";
            elseif($pagina == "criarpersonagem") (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/jogo.php" : include "paginas/criarpersonagem.php";
            elseif($pagina == "cadastrar") (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/jogo.php" : include "paginas/criarpersonagem.php";
            elseif($pagina == "dungeon") (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/dungeon.php" : include "paginas/criarpersonagem.php";
            elseif($pagina == "market") (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/market.php" : include "paginas/criarpersonagem.php";
            elseif($pagina == "batalha") (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/batalha.php" : include "paginas/criarpersonagem.php";
            elseif($pagina == "sair") (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/sair.php" : include "paginas/sair.php";
            else (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/jogo.php" : include "paginas/criarpersonagem.php";

        }      
        else
        {
            if($pagina == "jogo") include "paginas/login.php";
            elseif($pagina == "login") include "paginas/login.php";
            elseif($pagina == "criarpersonagem") include "paginas/login.php";
            elseif($pagina == "dungeon") include "paginas/login.php";
            elseif($pagina == "market") include "paginas/login.php";
            elseif($pagina == "batalha") include "paginas/login.php";
            elseif($pagina == "sair") include "paginas/login.php";
            elseif($pagina == "cadastrar") include "paginas/cadastrar.php";
            else include "paginas/login.php";
        }
    }
    else {
        if(isset($_SESSION['id_player'])){
            (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/jogo.php" : include "paginas/criarpersonagem.php";
            } else include "paginas/login.php";
        }
}
else {
    if(isset($_SESSION['id_player'])){
        (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) ? include "paginas/jogo.php" : include "paginas/criarpersonagem.php";
        } else include "paginas/login.php";
    }
?>

</body>
</html>