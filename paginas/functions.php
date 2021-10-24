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

function infos_item($id_inventario,$equipado){

        $id_personagem = $_SESSION['id_personagem'];

        $sql = "SELECT it.nm_item nome, it.imagem, sta*(refino+1) sta, `str`*(refino+1) `str`, `int`*(refino+1) `int`, dex*(refino+1) dex, refino, it.tipo
                FROM rpg.inventarios i
                JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
                JOIN rpg.atributos a ON i.id_item = a.id_item
                JOIN rpg.itens it ON it.id_item = i.id_item
                WHERE i.id_personagem = '{$id_personagem}' AND i.id_inventario = {$id_inventario}";
        $equipamento = mysqli_fetch_assoc(mysqli_query($GLOBALS['conexao'], $sql));

        $infos_item['nome'] = $equipamento['nome'];
        $infos_item['imagem'] = $equipamento['imagem'];
        $infos_item['sta'] = $equipamento['sta'];
        $infos_item['str'] = $equipamento['str'];
        $infos_item['int'] = $equipamento['int'];
        $infos_item['dex'] = $equipamento['dex'];
        $infos_item['ref'] = $equipamento['refino'];
        $infos_item['tipo'] = $equipamento['tipo'];
        $infos_item['equipado'] = $equipado;
        $infos_item['id_inventario'] = $id_inventario;

        return $infos_item;
}

function preencher_slots($equipado,$indice = 0,$slot = []){

        $i = $indice;
        if($equipado == "N") $order = "iv.data ASC";
        else $order = "i.tipo ASC";

        $sql = "SELECT i.id_item, i.imagem, i.nm_item, i.lv, i.valor, i.id_classe, `sta`, `str`, `int`, `dex`, iv.equipado, iv.id_inventario, iv.data, refino, i.tipo
            FROM rpg.inventarios iv
            JOIN rpg.itens i ON i.id_item = iv.id_item 
            JOIN rpg.atributos a ON i.id_item = a.id_item
            JOIN rpg.personagens p ON p.id_personagem = iv.id_personagem
            WHERE p.id_personagem = '{$_SESSION['id_personagem']}'
            AND iv.equipado = '{$equipado}'
            ORDER BY $order";
        $resultado = mysqli_query($GLOBALS['conexao'], $sql);
        while ($info_item = mysqli_fetch_assoc($resultado)) {
            $slot[$i]['id_item'] = $info_item['id_item'];
            $slot[$i]['imagem'] = $info_item['imagem'];
            $slot[$i]['nm_item'] = $info_item['nm_item'];
            $slot[$i]['lv'] = $info_item['lv'];
            $slot[$i]['valor'] = $info_item['valor'];
            $slot[$i]['id_classe'] = $info_item['id_classe'];
            $slot[$i]['sta'] = $info_item['sta'] * ($info_item['refino'] + 1);
            $slot[$i]['str'] = $info_item['str'] * ($info_item['refino'] + 1);
            $slot[$i]['int'] = $info_item['int'] * ($info_item['refino'] + 1);
            $slot[$i]['dex'] = $info_item['dex'] * ($info_item['refino'] + 1);
            $slot[$i]['tipo'] = $info_item['tipo'];
            $slot[$i]['ref'] = $info_item['refino'];
            $slot[$i]['equipado'] = $info_item['equipado'];
            $slot[$i]['id_inventario'] = $info_item['id_inventario'];
            $i++;
        }

        return $slot;
}