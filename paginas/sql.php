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

        $id_player = $_SESSION['id_player'];
        
        $id_personagem = $_SESSION['id_personagem'];

        $id_inventario = isset($_POST['id_inventario']) ? $_POST['id_inventario'] : 0;

        $equipado = $_POST['equipado'];

        $sql = "SELECT id_inventario, tipo FROM rpg.inventarios iv
        JOIN rpg.itens it ON it.id_item = iv.id_item
        where id_personagem = '{$id_personagem}'
        and id_inventario = '{$id_inventario}'";
        $item_selecionado = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $sql = "SELECT id_equipamento, i.tipo, refino, e.id_item
                FROM rpg.equipamentos e
                JOIN rpg.itens i ON i.id_item = e.id_item
                WHERE id_personagem = '{$id_personagem}'
                AND tipo = '{$item_selecionado['tipo']}'";

        $item_equipado = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $item_equipado['tipo'] = isset($item_equipado['tipo']) ? $item_equipado['tipo'] : 0;
        $item_equipado['id_equipamento'] = isset($item_equipado['id_equipamento']) ? $item_equipado['id_equipamento'] : 0;

                if ($item_selecionado['tipo'] == $item_equipado['tipo']) {
                        $infos_item = infos_item($id_inventario,"N");
                        
                        $sql = "UPDATE `inventarios` SET `refino` = '{$item_equipado['refino']}', id_item = '{$item_equipado['id_item']}' WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$id_inventario}'";
                        mysqli_query($conexao, $sql);

                        $sql = "SELECT * FROM rpg.equipamentos e
                                WHERE id_personagem = '{$id_personagem}'
                                AND slot = '{$infos_item['tipo']}'";
        
                        $id_equipamento = mysqli_fetch_assoc(mysqli_query($conexao, $sql));
        
                        $sql = "UPDATE `equipamentos` SET `refino` = '{$infos_item['ref']}', id_item = '{$infos_item['id_item']}' WHERE id_personagem = '{$id_personagem}' AND id_equipamento = '{$item_equipado['id_equipamento']}'";
                        mysqli_query($conexao, $sql);
                } else {
                        $infos_item = infos_item($id_inventario,"N");
                        
                        $sql = "UPDATE `inventarios` SET `refino` = null, id_item = null WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$id_inventario}'";
                        mysqli_query($conexao, $sql);

                        $sql = "SELECT * FROM rpg.equipamentos e
                                WHERE id_personagem = '{$id_personagem}'
                                AND slot = '{$infos_item['tipo']}'";
        
                        $id_equipamento = mysqli_fetch_assoc(mysqli_query($conexao, $sql));
        
                        $sql = "UPDATE `equipamentos` SET `refino` = '{$infos_item['ref']}', id_item = '{$infos_item['id_item']}' WHERE id_personagem = '{$id_personagem}' AND id_equipamento = '{$id_equipamento['id_equipamento']}'";
                        mysqli_query($conexao, $sql);
                }

        $resultado = [];

        $resultado['infos_item'] = $infos_item;

        $atributos = att_atributos($id_personagem);

        $resultado['atributos'] = $atributos;

        echo json_encode($resultado);
}

if($opcao == "desequipar"){

        $id_equipamento = isset($_POST['id_equipamento']) ? $_POST['id_equipamento'] : 0;

        $id_player = $_SESSION['id_player'];
        
        $id_personagem = $_SESSION['id_personagem'];

        $equipado = $_POST['equipado'];

        $sql = "SELECT MIN(id_inventario) AS primeiro FROM rpg.inventarios e
        WHERE id_personagem = '{$id_personagem}'
        AND id_item IS NULL";

        $slot_vago = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        $infos_item = infos_item($id_equipamento,"S");

        $sql = "UPDATE `equipamentos` SET `refino` = null, id_item = null WHERE id_personagem = '{$id_personagem}' AND id_equipamento = '{$id_equipamento}'";
        mysqli_query($conexao, $sql);
                
        $sql = "UPDATE `inventarios` SET `refino` = '{$infos_item['ref']}', id_item = '{$infos_item['id_item']}' WHERE id_personagem = '{$id_personagem}' AND id_inventario = '{$slot_vago['primeiro']}'";
        mysqli_query($conexao, $sql);

                $sql = "SELECT * FROM rpg.equipamentos e
                        WHERE id_personagem = '{$id_personagem}'
                        AND slot = '{$infos_item['tipo']}'";

                $id_equipamentos = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

$resultado = [];

$resultado['infos_item'] = $infos_item;

$atributos = att_atributos($id_personagem);

$resultado['atributos'] = $atributos;

echo json_encode($resultado);

}

if ($opcao == "forja") {

        $id_personagem = $_SESSION['id_personagem'];

        $id_inventario = $_POST['id_inventario'];

        $equipado = $_POST['equipado'];

        $infos_item = infos_item($id_inventario,"N");

        echo json_encode($infos_item);
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

        $atributos = att_atributos($id_personagem);

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

if ($opcao == "custo") {

        $custo_refinar = $_POST['custo_refinar'];
        $gold_anterior = $_SESSION['gold'];

        if($custo_refinar<=$_SESSION['gold']) $_SESSION['gold'] -= $custo_refinar;

        $atributos['gold'] = $_SESSION['gold'];
        $atributos['gold_anterior'] = $gold_anterior;
        $atributos['custo_refinar'] = $custo_refinar;

        $atributos_json = json_encode($atributos);
        echo json_encode($atributos);
}

if ($opcao == "market") {


        $id_personagem = $_SESSION['id_personagem'];

        $id_item = $_POST['id_item'];

        $id_inventario = isset($_POST['id_inventario']) ? $_POST['id_inventario'] : 0;

        $valor = $_POST['valor'];

        $tipo = $_POST['tipo'];

        if ($tipo == "c" && $valor <= $_SESSION['gold']) {

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

                        $sql = "UPDATE `rpg`.`inventarios` SET `refino` = '0', `id_item` = '{$id_item}', `data`= now() WHERE `id_inventario` = '{$id_inventario['id_inventario']}'";

                        mysqli_query($conexao, $sql);
                }
        } 
        if ($tipo == "v") {

                $gold_atual = ($_SESSION['gold'] + $valor / 2);

                $_SESSION['gold'] = $gold_atual;

                $sql = "UPDATE `rpg`.`personagens` SET `gold` = '{$gold_atual}' WHERE `id_personagem` = '{$id_personagem}'";

                mysqli_query($conexao, $sql);

                $sql = "UPDATE `rpg`.`inventarios` SET `refino` = '0', `id_item` = NULL, `equipado` = 'N', `data`= now()  WHERE `id_inventario` = '{$id_inventario}'";

                mysqli_query($conexao, $sql);
        }

        $atributos['gold'] = $_SESSION['gold'];
        $atributos['valor'] = $valor;

        $atributos_json = json_encode($atributos);
        echo json_encode($atributos);
}

if ($opcao == "alterar_senha") {

        $senha_atual = $_POST['senha_atual'];
        $nova_senha = $_POST['nova_senha'];
        $confirmacao_senha = $_POST['confirmacao_senha'];
        $senha_atual = md5($senha_atual);
        if ($senha_atual == $_SESSION['senha']) {
                if ($nova_senha == $confirmacao_senha) {
                        $nova_senha = md5($nova_senha);
                        $sql = "UPDATE `player` SET `senha`='{$nova_senha}' WHERE `id_player` = '{$_SESSION['id_personagem']}'";
                        $executar = mysqli_query($conexao, $sql);
                        echo "<script type=\"text/javascript\">
                        alert ('Senha Alterada com Sucesso!');
                        location.href = 'http://localhost/rpg/index.php?pagina=perfil';
                        </script>";
                } else {
                        echo "<script type=\"text/javascript\">
                        alert ('As senhas nao coincidem');
                        location.href = 'http://localhost/rpg/index.php?pagina=perfil';
                        </script>";
                }
        } else {
                echo "<script type=\"text/javascript\">
                        alert ('Senha Atual Invalida!');
                        location.href = 'http://localhost/rpg/index.php?pagina=perfil';
                        </script>";
        }
}

if ($opcao == "login") {

        $login = $_POST['login'];
        $senha = $_POST['senha'];


        $senha = md5($senha);
        $sql = "SELECT p.id_player, p.login, p.senha, ps.id_personagem FROM rpg.player p
            LEFT JOIN rpg.personagens ps ON ps.id_player = p.id_player
            WHERE login = '{$login}' 
            AND senha = '{$senha}'";
        $valida_login = mysqli_num_rows(mysqli_query($conexao, $sql));
        $info_player = mysqli_fetch_assoc(mysqli_query($conexao, $sql));
        if ($valida_login == 1) {
                $_SESSION['senha'] = $info_player['senha'];
                $_SESSION['login'] = $info_player['login'];
                $_SESSION['id_personagem'] = $info_player['id_personagem'];
                $_SESSION['id_player'] = $info_player['id_player'];
                $info_player = $_SESSION['id_player'];
                $id_personagem = $_SESSION['id_personagem'];
                $id_player = $_SESSION['id_player'];
                if (!isset($id_personagem)) {
                        header("location: http://localhost/rpg/index.php?pagina=criarpersonagem");
                }

                att_atributos($id_personagem);

                header("location: http://localhost/rpg/index.php?pagina=jogo");
        } else echo "<script type=\"text/javascript\">
                                alert ('Login ou senha incorretos!');
                                location.href = 'http://localhost/rpg/';
                                </script>";
}

if ($opcao == "novo_usuario") {

        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $senha = md5($senha);
        $sql = "SELECT `login` FROM player WHERE login = '{$login}'";
        $login_existe = mysqli_num_rows(mysqli_query($conexao, $sql));
        if ($login_existe == 0) {
                $sql = "INSERT INTO `player`(`login`,`senha`) VALUES ( '$login', '$senha')";
                $executar = mysqli_query($conexao, $sql);
                echo "<script type=\"text/javascript\">
                                alert ('Cadastro realizado com sucesso!');
                                location.href = 'http://localhost/rpg/';
                                </script>";
        } else echo "<script type=\"text/javascript\">
                                alert ('Login já cadastrado!');
                                location.href = 'http://localhost/rpg/index.php?pagina=cadastrar';
                                </script>";
}

if ($opcao == "novo_personagem") {

        $nick = $_POST['nick'];
        $classe = $_POST['classe'];
        $id_player = $_SESSION['id_player'];

        $sql = "SELECT nick FROM personagens WHERE nick = '{$nick}'";
        $novo_personagem = mysqli_num_rows(mysqli_query($conexao, $sql));
        if (!empty($novo_personagem)) {
                echo "<script type=\"text/javascript\">
                alert ('Este nome já esta sendo utilizado!');   
                location.href = 'http://localhost/rpg/index.php?pagina=criarpersonagem';                 
                </script>";
        } else {
                $sql = "INSERT INTO `personagens`(`nick`, `id_classe`, `id_player`) 
                 VALUES ( '$nick', '$classe', '$id_player' )";
                $executar = mysqli_query($conexao, $sql);

                $sql = "SELECT `id_personagem` 
                FROM `personagens`
                WHERE id_player = '{$id_player}'";
                $id_personagem =mysqli_fetch_assoc(mysqli_query($conexao, $sql));
        
                for($i=1;$i<=8;$i++){
                $sql = "INSERT INTO `equipamentos`(`slot`,`id_personagem`) VALUES ( '$i', '{$id_personagem['id_personagem']}')";
                mysqli_query($conexao, $sql); 
                }//adiciona um slot aos equipamentos
        
                for($i=1;$i<=15;$i++){
                $sql = "INSERT INTO `inventarios`(`slot`,`id_personagem`) VALUES ( '$i', '{$id_personagem['id_personagem']}')";
                mysqli_query($conexao, $sql); 
                }//adiciona um slot ao inventário
        }
                session_unset();
                session_destroy();
                echo "<script type=\"text/javascript\">
                alert ('Personagem Criado com Sucesso!');   
                location.href = 'http://localhost/rpg';                 
                </script>";
        }
