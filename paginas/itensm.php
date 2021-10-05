<?php

session_start();

include "conexao.php";

$id_personagem = $_SESSION['id_personagem'];

$id_inventario = $_POST['id_inventario'];

$equipado = $_POST['equipado'];

$sql = "SELECT it.nm_item nome, sta*(refino+1) sta, `str`*(refino+1) `str`, `int`*(refino+1) `int`, dex*(refino+1) dex
FROM rpg.inventarios i
JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
JOIN rpg.atributos a ON i.id_item = a.id_item
JOIN rpg.itens it ON it.id_item = i.id_item
WHERE i.id_personagem = '{$id_personagem}' AND i.id_inventario = {$id_inventario}";
$equipamento = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

$atributos_json = json_encode($atributos);
echo json_encode($atributos);

?>