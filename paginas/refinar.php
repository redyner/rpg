<?php

session_start();

include 'functions.php';

$id_personagem = $_SESSION['id_personagem'];

$id_inventario = $_POST['id_inventario'];

$selecionado = $_POST['equipado'];

$refino = $_POST['ref'];

$custo = ($refino+1)*25;

$refino +=1;

$_SESSION['gold'] = ($_SESSION['gold'] - $custo);

$sql = "UPDATE `rpg`.`inventarios` SET `refino` = '{$refino}' WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$id_inventario}'";
mysqli_query($conexao,$sql);

$sql = "UPDATE `rpg`.`personagens` SET `gold` = '{$_SESSION['gold']}' WHERE id_personagem = '{$id_personagem}'";
mysqli_query($conexao,$sql);


$sql = "SELECT nick, lv, xp, xp_max, c.nm_classe, sta, `str`, `int`, dex, gold 
FROM rpg.personagens p 
JOIN rpg.classes c ON c.id_classe = p.id_classe
JOIN rpg.atributos a ON c.id_classe = a.id_classe 
WHERE p.id_personagem = '{$_SESSION['id_personagem']}'";
$info_player = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

$sql = "SELECT sum(sta*(refino+1)) sta, sum(`str`*(refino+1)) `str`, sum(`int`*(refino+1)) `int`, sum(dex*(refino+1)) dex
FROM rpg.inventarios i
JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
JOIN rpg.atributos a ON i.id_item = a.id_item
WHERE i.id_personagem = '{$id_personagem}' AND i.equipado IN ('S','s')";
$equipamento = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

if(!empty($equipamento)){
    $_SESSION['sta_itens_equipados'] = $equipamento['sta'];
    $_SESSION['str_itens_equipados'] = $equipamento['str'];
    $_SESSION['int_itens_equipados'] = $equipamento['int'];
    $_SESSION['dex_itens_equipados'] = $equipamento['dex'];

}else{
    $_SESSION['sta_itens_equipados'] = 0;
    $_SESSION['str_itens_equipados'] = 0;
    $_SESSION['int_itens_equipados'] = 0;
    $_SESSION['dex_itens_equipados'] = 0;
}

$_SESSION['sta'] = ($info_player['sta']+($info_player['lv']*$info_player['sta']))+$_SESSION['sta_itens_equipados'];
$_SESSION['str'] = ($info_player['str']+($info_player['lv']*$info_player['str']))+$_SESSION['str_itens_equipados'];
$_SESSION['int'] = ($info_player['int']+($info_player['lv']*$info_player['int']))+$_SESSION['int_itens_equipados'];
$_SESSION['dex'] = ($info_player['dex']+($info_player['lv']*$info_player['dex']))+$_SESSION['dex_itens_equipados'];

$atributos['sta'] = $_SESSION['sta'];
$atributos['str'] = $_SESSION['str'];
$atributos['int'] = $_SESSION['int'];
$atributos['dex'] = $_SESSION['dex'];

$sql = "SELECT it.nm_item nome, sta*(refino+1) sta, `str`*(refino+1) `str`, `int`*(refino+1) `int`, dex*(refino+1) dex, refino
FROM rpg.inventarios i
JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
JOIN rpg.atributos a ON i.id_item = a.id_item
JOIN rpg.itens it ON it.id_item = i.id_item
WHERE i.id_personagem = '{$id_personagem}' AND i.id_inventario = {$id_inventario}";
$item_refinado = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

$atributos['nome'] = $item_refinado['nome'];
$atributos['sta'] = $item_refinado['sta'];
$atributos['str'] = $item_refinado['str'];
$atributos['int'] = $item_refinado['int'];
$atributos['dex'] = $item_refinado['dex'];
$atributos['ref'] = $item_refinado['refino'];
$atributos['id_inventario'] = $id_inventario;

$atributos_json = json_encode($atributos);
echo json_encode($atributos);

?>