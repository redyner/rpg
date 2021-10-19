<?php



$GLOBALS['conexao'] = conexao();
$conexao = $GLOBALS['conexao'];


function conexao()
{

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname   = "rpg";

    // Create connection
    $conexao = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if (!$conexao) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "";

    return $conexao;
}

function att_atributos($id_personagem)
{
        $sql = "SELECT nick, lv, xp, xp_max, c.nm_classe, sta, `str`, `int`, dex, gold 
        FROM rpg.personagens p 
        JOIN rpg.classes c ON c.id_classe = p.id_classe
        JOIN rpg.atributos a ON c.id_classe = a.id_classe 
        WHERE p.id_personagem = '{$_SESSION['id_personagem']}'";
        $info_player = mysqli_fetch_assoc(mysqli_query($GLOBALS['conexao'], $sql));

        $sql = "SELECT sum(sta*(refino+1)) sta, sum(`str`*(refino+1)) `str`, sum(`int`*(refino+1)) `int`, sum(dex*(refino+1)) dex
        FROM rpg.inventarios i
        JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
        JOIN rpg.atributos a ON i.id_item = a.id_item
        WHERE i.id_personagem = '{$id_personagem}' AND i.equipado IN ('S','s')";
        $equipamento = mysqli_fetch_assoc(mysqli_query($GLOBALS['conexao'], $sql));

        if (!empty($equipamento)) {
                $_SESSION['sta_itens_equipados'] = $equipamento['sta'];
                $_SESSION['str_itens_equipados'] = $equipamento['str'];
                $_SESSION['int_itens_equipados'] = $equipamento['int'];
                $_SESSION['dex_itens_equipados'] = $equipamento['dex'];
        } else {
                $_SESSION['sta_itens_equipados'] = 0;
                $_SESSION['str_itens_equipados'] = 0;
                $_SESSION['int_itens_equipados'] = 0;
                $_SESSION['dex_itens_equipados'] = 0;
        }

        $_SESSION['sta'] = ($info_player['sta'] + ($info_player['lv'] * $info_player['sta'])) + $_SESSION['sta_itens_equipados'];
        $_SESSION['str'] = ($info_player['str'] + ($info_player['lv'] * $info_player['str'])) + $_SESSION['str_itens_equipados'];
        $_SESSION['int'] = ($info_player['int'] + ($info_player['lv'] * $info_player['int'])) + $_SESSION['int_itens_equipados'];
        $_SESSION['dex'] = ($info_player['dex'] + ($info_player['lv'] * $info_player['dex'])) + $_SESSION['dex_itens_equipados'];

        $atributos['sta'] = $_SESSION['sta'];
        $atributos['str'] = $_SESSION['str'];
        $atributos['int'] = $_SESSION['int'];
        $atributos['dex'] = $_SESSION['dex'];

        return $atributos;
}

function avatarClasse($classe){

        $sql = "SELECT `imagem` FROM `classes` WHERE `nm_classe` = '{$classe}'";
        $resultado = mysqli_fetch_assoc(mysqli_query($GLOBALS['conexao'], $sql));
        $imagem = $resultado['imagem'];

        return $imagem;
}
function valorPontos($val){

       $resultado = number_format($val, 0, ',', '.');

        return $resultado;
}
