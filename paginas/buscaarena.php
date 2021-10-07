<?php

session_start();
include 'functions.php';

$nick = $_POST['busca_nick'];

$sql = "SELECT sum(sta*(refino+1)) sta, sum(`str`*(refino+1)) `str`, sum(`int`*(refino+1)) `int`, sum(dex*(refino+1)) dex, refino
        FROM rpg.inventarios i
        JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
        JOIN rpg.atributos a ON i.id_item = a.id_item
        WHERE p.nick = '{$nick}' 
        AND i.slot IS NULL";
$equipamento = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

$sql = "SELECT nick, lv, c.nm_classe, sta, `str`, `int`, dex 
FROM rpg.personagens p 
JOIN rpg.classes c ON c.id_classe = p.id_classe
JOIN rpg.atributos a ON c.id_classe = a.id_classe 
WHERE p.nick = '{$nick}'";
$info_player = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

$sta_itens = $equipamento['sta'];
$str_itens = $equipamento['str'];
$int_itens = $equipamento['int'];
$dex_itens = $equipamento['dex'];
$nick_inimigo = $info_player['nick'];
$lv_inimigo = $info_player['lv'];
$classe_inimigo  = $info_player['nm_classe'];
$sta_inimigo = ($info_player['sta']+($info_player['lv']*$info_player['sta']))+$equipamento['sta'];
$str_inimigo = ($info_player['str']+($info_player['lv']*$info_player['str']))+$equipamento['str'];
$int_inimigo = ($info_player['int']+($info_player['lv']*$info_player['int']))+$equipamento['int'];
$dex_inimigo = ($info_player['dex']+($info_player['lv']*$info_player['dex']))+$equipamento['dex'];
$hp_inimigo = $sta_inimigo*3;
$hp_batalha_inimigo = $hp_inimigo;

$inimigo = array(
    "nick_inimigo" => $nick_inimigo,
    "sta_inimigo" => $sta_inimigo,
    "str_inimigo" => $str_inimigo,
    "int_inimigo" => $int_inimigo,
    "dex_inimigo" => $dex_inimigo,
    "lv_inimigo" => $lv_inimigo,
    "classe_inimigo" => $classe_inimigo
);

echo json_encode($inimigo);


?>