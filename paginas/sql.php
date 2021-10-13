<?php

session_start();

include 'functions.php';


$opcao = $_POST['opcao'];



if ($opcao == "levelup") {

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

        if (!empty($lv)) {
                $sql = "UPDATE `personagens` SET `lv` = {$lv}, `xp` = {$xp}, `xp_max` = {$xp_max}, `gold` = {$gold} WHERE id_personagem = '{$id_player}'";
                mysqli_query($conexao, $sql);
                $_SESSION['lv'] = $lv;
                $_SESSION['xp'] = $xp;
                $_SESSION['xp_max'] = $xp_max;
                $_SESSION['sta'] = $sta;
                $_SESSION['str'] = $str;
                $_SESSION['int'] = $int;
                $_SESSION['dex'] = $dex;
                $_SESSION['gold'] = $gold;
        } else {
                $sql = "UPDATE `personagens` SET `xp` = {$xp}, `gold` = {$gold} WHERE id_personagem = '{$id_player}'";
                mysqli_query($conexao, $sql);
                $_SESSION['xp'] = $xp;
                $_SESSION['gold'] = $gold;
        }
}

if ($opcao == "buscaarena") {


        $nick = $_POST['busca_nick'];

        $sql = "SELECT sum(sta*(refino+1)) sta, sum(`str`*(refino+1)) `str`, sum(`int`*(refino+1)) `int`, sum(dex*(refino+1)) dex, refino
                FROM rpg.inventarios i
                JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
                JOIN rpg.atributos a ON i.id_item = a.id_item
                WHERE p.nick = '{$nick}' 
                AND i.slot IS NULL";
        $equipamento = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $sql = "SELECT nick, lv, c.nm_classe, sta, `str`, `int`, dex 
                FROM rpg.personagens p 
                JOIN rpg.classes c ON c.id_classe = p.id_classe
                JOIN rpg.atributos a ON c.id_classe = a.id_classe 
                WHERE p.nick = '{$nick}'";
        $info_player = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $sta_itens = $equipamento['sta'];
        $str_itens = $equipamento['str'];
        $int_itens = $equipamento['int'];
        $dex_itens = $equipamento['dex'];
        $nick_inimigo = $info_player['nick'];
        $lv_inimigo = $info_player['lv'];
        $classe_inimigo  = $info_player['nm_classe'];
        $sta_inimigo = ($info_player['sta'] + ($info_player['lv'] * $info_player['sta'])) + $equipamento['sta'];
        $str_inimigo = ($info_player['str'] + ($info_player['lv'] * $info_player['str'])) + $equipamento['str'];
        $int_inimigo = ($info_player['int'] + ($info_player['lv'] * $info_player['int'])) + $equipamento['int'];
        $dex_inimigo = ($info_player['dex'] + ($info_player['lv'] * $info_player['dex'])) + $equipamento['dex'];
        $hp_inimigo = $sta_inimigo * 3;
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
}

if ($opcao == "equipar") {
        $id_personagem = $_SESSION['id_personagem'];

        $id_inventario = $_POST['id_inventario'];

        $equipado = $_POST['equipado'];

        $sql = "SELECT id_inventario, equipado, tipo FROM rpg.inventarios iv
                JOIN rpg.itens it ON it.id_item = iv.id_item
                where id_personagem = '{$id_personagem}'
                and id_inventario = '{$id_inventario}'";
        $tipo_selecionado = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $sql = "SELECT id_inventario, equipado, tipo FROM rpg.inventarios iv
                JOIN rpg.itens it ON it.id_item = iv.id_item
                where id_personagem = '{$id_personagem}'
                and equipado = 'S'";
        $tipo_equipado = mysqli_fetch_assoc(mysqli_query($conexao, $sql));
        $tipo_equipado['tipo'] = isset($tipo_equipado['tipo']) ? $tipo_equipado['tipo'] : 0;
        $tipo_equipado['id_inventario'] = isset($tipo_equipado['id_inventario']) ? $tipo_equipado['id_inventario'] : 0;

        if ($tipo_selecionado['tipo'] == $tipo_equipado['tipo'] && $tipo_selecionado['id_inventario'] != $tipo_equipado['id_inventario']) {
                $sql = "UPDATE `inventarios` SET `equipado` = '{$equipado}' WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$id_inventario}'";
                mysqli_query($conexao, $sql);
                $sql = "UPDATE `inventarios` SET `equipado` = 'N' WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$tipo_equipado['id_inventario']}'";
                mysqli_query($conexao, $sql);
        } else {
                $sql = "UPDATE `inventarios` SET `equipado` = '{$equipado}' WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$id_inventario}'";
                mysqli_query($conexao, $sql);
        }

        $atributos = att_atributos($conexao,$id_personagem);

        $atributos_json = json_encode($atributos);
        echo json_encode($atributos);
}

if ($opcao == "forja") {

        $id_personagem = $_SESSION['id_personagem'];

        $id_inventario = $_POST['id_inventario'];

        $equipado = $_POST['equipado'];

        $sql = "SELECT it.nm_item nome, sta*(refino+1) sta, `str`*(refino+1) `str`, `int`*(refino+1) `int`, dex*(refino+1) dex, refino
FROM rpg.inventarios i
JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
JOIN rpg.atributos a ON i.id_item = a.id_item
JOIN rpg.itens it ON it.id_item = i.id_item
WHERE i.id_personagem = '{$id_personagem}' AND i.id_inventario = {$id_inventario}";
        $equipamento = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $atributos['nome'] = $equipamento['nome'];
        $atributos['sta'] = $equipamento['sta'];
        $atributos['str'] = $equipamento['str'];
        $atributos['int'] = $equipamento['int'];
        $atributos['dex'] = $equipamento['dex'];
        $atributos['ref'] = $equipamento['refino'];
        $atributos['equipado'] = $equipado;
        $atributos['id_inventario'] = $id_inventario;

        $atributos_json = json_encode($atributos);
        echo json_encode($atributos);
}

if ($opcao == "refinar") {


        $id_personagem = $_SESSION['id_personagem'];

        $id_inventario = $_POST['id_inventario'];

        $selecionado = $_POST['equipado'];

        $refino = $_POST['ref'];

        $custo = ($refino + 1) * 25;

        $refino += 1;

        $_SESSION['gold'] = ($_SESSION['gold'] - $custo);

        $sql = "UPDATE `rpg`.`inventarios` SET `refino` = '{$refino}' WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$id_inventario}'";
        mysqli_query($conexao, $sql);

        $sql = "UPDATE `rpg`.`personagens` SET `gold` = '{$_SESSION['gold']}' WHERE id_personagem = '{$id_personagem}'";
        mysqli_query($conexao, $sql);

        $atributos = att_atributos($conexao,$id_personagem);

        $sql = "SELECT it.nm_item nome, sta*(refino+1) sta, `str`*(refino+1) `str`, `int`*(refino+1) `int`, dex*(refino+1) dex, refino
        FROM rpg.inventarios i
        JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
        JOIN rpg.atributos a ON i.id_item = a.id_item
        JOIN rpg.itens it ON it.id_item = i.id_item
        WHERE i.id_personagem = '{$id_personagem}' AND i.id_inventario = {$id_inventario}";
        $item_refinado = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $atributos['nome'] = $item_refinado['nome'];
        $atributos['sta'] = $item_refinado['sta'];
        $atributos['str'] = $item_refinado['str'];
        $atributos['int'] = $item_refinado['int'];
        $atributos['dex'] = $item_refinado['dex'];
        $atributos['ref'] = $item_refinado['refino'];
        $atributos['id_inventario'] = $id_inventario;

        $atributos_json = json_encode($atributos);
        echo json_encode($atributos);
}

if ($opcao == "consulta") {

        $atributos['gold'] = $_SESSION['gold'];

        $atributos_json = json_encode($atributos);
        echo json_encode($atributos);
}

if ($opcao == "market") {


        $id_personagem = $_SESSION['id_personagem'];

        $id_item = $_POST['id_item'];

        $id_inventario = isset($_POST['id_inventario']) ? $_POST['id_inventario'] : 0;

        $valor = $_POST['valor'];

        $tipo = $_POST['tipo'];

        if ($tipo == "c") {
                $sql = "SELECT count(*) `count` FROM rpg.inventarios
                WHERE id_personagem = '{$id_personagem}'";

                $count = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

                if ($count['count'] < 15) {
                        $slot = $count['count'] + 1;
                        $sql = "INSERT INTO `inventarios`(`slot`,`id_personagem`) VALUES ( '$slot', '$id_personagem')";

                        mysqli_query($conexao, $sql); //adiciona um slot ao inventário
                }

                $sql = "SELECT COUNT(*) `count` FROM rpg.inventarios
                WHERE id_personagem = '{$id_personagem}'
                AND id_item IS NULL ";

                $count = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

                if ($count['count'] != 0) {
                        $sql = "SELECT id_inventario FROM rpg.inventarios
                WHERE id_personagem = '{$id_personagem}'
                AND id_item IS NULL 
                LIMIT 1";

                        $id_inventario = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

                        $gold_atual = ($_SESSION['gold'] - $valor);

                        $_SESSION['gold'] = $gold_atual;

                        $sql = "UPDATE `rpg`.`personagens` SET `gold` = '{$gold_atual}' WHERE `id_personagem` = '{$id_personagem}'";

                        mysqli_query($conexao, $sql);

                        $sql = "UPDATE `rpg`.`inventarios` SET `refino` = '0', `id_item` = '{$id_item}' WHERE `id_inventario` = '{$id_inventario['id_inventario']}'";

                        mysqli_query($conexao, $sql);
                }
        } else {

                $gold_atual = ($_SESSION['gold'] + $valor / 2);

                $_SESSION['gold'] = $gold_atual;

                $sql = "UPDATE `rpg`.`personagens` SET `gold` = '{$gold_atual}' WHERE `id_personagem` = '{$id_personagem}'";

                mysqli_query($conexao, $sql);

                $sql = "UPDATE `rpg`.`inventarios` SET `refino` = '0', `id_item` = NULL, `equipado` = 'N'  WHERE `id_inventario` = '{$id_inventario}'";

                mysqli_query($conexao, $sql);
        }

        $atributos['gold'] = $_SESSION['gold'];

        $atributos_json = json_encode($atributos);
        echo json_encode($atributos);
}

function att_atributos($conexao,$id_personagem)
{
        $sql = "SELECT nick, lv, xp, xp_max, c.nm_classe, sta, `str`, `int`, dex, gold 
        FROM rpg.personagens p 
        JOIN rpg.classes c ON c.id_classe = p.id_classe
        JOIN rpg.atributos a ON c.id_classe = a.id_classe 
        WHERE p.id_personagem = '{$_SESSION['id_personagem']}'";
        $info_player = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $sql = "SELECT sum(sta*(refino+1)) sta, sum(`str`*(refino+1)) `str`, sum(`int`*(refino+1)) `int`, sum(dex*(refino+1)) dex
        FROM rpg.inventarios i
        JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
        JOIN rpg.atributos a ON i.id_item = a.id_item
        WHERE i.id_personagem = '{$id_personagem}' AND i.equipado IN ('S','s')";
        $equipamento = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

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
 