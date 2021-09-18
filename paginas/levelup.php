<?php

session_start();
include "conexao.php";

$id_player = $_SESSION['id_player'];

$personagem = $_POST['data'];

$dados = json_decode($personagem, true);

$lv = $dados['lv'];
$xp = $dados['xp'];
$xp_max = $dados['xp_max'];
$gold = $dados['gold'];
$sta = $dados['sta_personagem'];
$str = $dados['str_personagem'];
$int = $dados['int_personagem'];
$dex = $dados['dex_personagem'];

if(!empty($lv)){
    $sql = "UPDATE `personagens` SET `lv` = {$lv}, `xp` = {$xp}, `xp_max` = {$xp_max}, `gold` = {$gold} WHERE id_personagem = '{$id_player}'";
    mysqli_query($conexao,$sql);
    $_SESSION['lv'] = $lv;
    $_SESSION['xp'] = $xp;
    $_SESSION['xp_max'] = $xp_max;
    $_SESSION['sta'] = $sta;
    $_SESSION['str'] = $str;
    $_SESSION['int'] = $int;
    $_SESSION['dex'] = $dex;
    $_SESSION['gold'] = $gold;

} 
else {
    $sql = "UPDATE `personagens` SET `xp` = {$xp}, `gold` = {$gold} WHERE id_personagem = '{$id_player}'";
    mysqli_query($conexao,$sql);
    $_SESSION['xp'] = $xp;
    $_SESSION['gold'] = $gold;
}

?>