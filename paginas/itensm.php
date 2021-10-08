<?php

session_start();

include 'functions.php';

$id_personagem = $_SESSION['id_personagem'];

$id_item = $_POST['id_item'];

$id_inventario = isset($_POST['id_inventario']) ? $_POST['id_inventario'] : 0;

$valor = $_POST['valor'];

$tipo = $_POST['tipo'];

if($tipo == "c")
{
        $sql = "SELECT count(*) `count` FROM rpg.inventarios
                WHERE id_personagem = '{$id_personagem}'";

        $count = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

        if ($count['count']<15)
        {
                $slot = $count['count']+1;
                $sql = "INSERT INTO `inventarios`(`slot`,`id_personagem`) VALUES ( '$slot', '$id_personagem')";

                mysqli_query($conexao,$sql); //adiciona um slot ao inventário
        }

        $sql = "SELECT COUNT(*) `count` FROM rpg.inventarios
                WHERE id_personagem = '{$id_personagem}'
                AND id_item IS NULL ";

        $count = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

        if ($count['count']!=0)
        {
                $sql = "SELECT id_inventario FROM rpg.inventarios
                WHERE id_personagem = '{$id_personagem}'
                AND id_item IS NULL 
                LIMIT 1";

                $id_inventario = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

                $gold_atual = ($_SESSION['gold'] - $valor);

                $_SESSION['gold'] = $gold_atual;

                $sql = "UPDATE `rpg`.`personagens` SET `gold` = '{$gold_atual}' WHERE `id_personagem` = '{$id_personagem}'";

                mysqli_query($conexao,$sql);

                $sql = "UPDATE `rpg`.`inventarios` SET `refino` = '0', `id_item` = '{$id_item}' WHERE `id_inventario` = '{$id_inventario['id_inventario']}'";

                mysqli_query($conexao,$sql);
        }
}
else
{

        $gold_atual = ($_SESSION['gold'] + $valor/2);

        $_SESSION['gold'] = $gold_atual;

        $sql = "UPDATE `rpg`.`personagens` SET `gold` = '{$gold_atual}' WHERE `id_personagem` = '{$id_personagem}'";

        mysqli_query($conexao,$sql);

        $sql = "UPDATE `rpg`.`inventarios` SET `refino` = '0', `id_item` = NULL  WHERE `id_inventario` = '{$id_inventario}'";

        mysqli_query($conexao,$sql);

}

$atributos['gold'] = $_SESSION['gold'];

$atributos_json = json_encode($atributos);
echo json_encode($atributos);

?>