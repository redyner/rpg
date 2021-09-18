<?php

session_start();
include "conexao.php";

$xp = $_POST['set_xp'];
$id_personagem = $_SESSION['id_personagem'];
$_POST['set_sta'];
$_POST['set_str'];
$_POST['set_int'];
$_POST['set_dex'];

$xp_inimigo = $xp;
$sql = "UPDATE `personagens` SET `xp` = {$xp} WHERE id_personagem = '{$id_personagem}'";
mysqli_query($conexao,$sql);
$sql = "SELECT `xp` FROM `personagens` WHERE id_personagem = '{$id_personagem}'";
$xp = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
$_SESSION['xp'] = $xp['xp'];

echo json_encode("<br><br><p id='fonte_combate'>Voce derrotou seu inimigo e ganhou ". $xp_inimigo. " de experiencia</p>");


?>