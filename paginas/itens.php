<?php

session_start();

include 'functions.php';

$id_personagem = $_SESSION['id_personagem'];

$id_inventario = $_POST['id_inventario'];

$equipado = $_POST['equipado'];

$sql = "UPDATE `inventarios` SET `equipado` = '{$equipado}' WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$id_inventario}'";
mysqli_query($conexao,$sql);

$sql = "SELECT it.nm_item nome, sta*(refino+1) sta, `str`*(refino+1) `str`, `int`*(refino+1) `int`, dex*(refino+1) dex
FROM rpg.inventarios i
JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
JOIN rpg.atributos a ON i.id_item = a.id_item
JOIN rpg.itens it ON it.id_item = i.id_item
WHERE i.id_personagem = '{$id_personagem}' AND i.id_inventario = {$id_inventario}";
$equipamento = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

if ($equipado == "S"){
    $_SESSION['sta_itens_equipados'] += $equipamento['sta'];
    $_SESSION['str_itens_equipados'] += $equipamento['str'];
    $_SESSION['int_itens_equipados'] += $equipamento['int'];
    $_SESSION['dex_itens_equipados'] += $equipamento['dex'];
    $_SESSION['sta'] += $equipamento['sta'];
    $_SESSION['str'] += $equipamento['str'];
    $_SESSION['int'] += $equipamento['int'];
    $_SESSION['dex'] += $equipamento['dex'];
}else{
    $_SESSION['sta_itens_equipados'] -= $equipamento['sta'];
    $_SESSION['str_itens_equipados'] -= $equipamento['str'];
    $_SESSION['int_itens_equipados'] -= $equipamento['int'];
    $_SESSION['dex_itens_equipados'] -= $equipamento['dex'];
    $_SESSION['sta'] -= $equipamento['sta'];
    $_SESSION['str'] -= $equipamento['str'];
    $_SESSION['int'] -= $equipamento['int'];
    $_SESSION['dex'] -= $equipamento['dex'];
}
$atributos['nome'] = $equipamento['nome'];
$atributos['sta'] = $_SESSION['sta'];
$atributos['str'] = $_SESSION['str'];
$atributos['int'] = $_SESSION['int'];
$atributos['dex'] = $_SESSION['dex'];

$atributos_json = json_encode($atributos);
echo json_encode($atributos);

?>