<?php
include "conexao.php";
$porcentagem_xp = $_SESSION['xp'] * 100 / $_SESSION['xp_max'];
if ($porcentagem_xp < 0) $porcentagem_xp = 0;
?>

<div id="painel_principal">
    <div id="logo"></div>
    <nav>
        <ul>
            <li><a href="http://localhost/rpg"> Pagina Inicial</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=dungeon">Dungeons</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=market">Market</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=forja">Forja</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=arena">Arena</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
            <li><a href="http://localhost/rpg/teste/teste.php">Teste Eventos</a></li>
            <li id="gold" style="float: right;">GOLD - <?php echo $_SESSION['gold'] ?></li>
        </ul>
    </nav>

    <div id="painel_personagem">

        <a href="">
            <div class="avatar_personagem_selecao" id="<?php echo $_SESSION['classe'] ?>"></div>
        </a>
        <div id="atributos_personagem">
            <br>
            <p id="atributo_xp">EXP</p>
            <div class="barra" id="barra_xp">
                <div id="xp_atual" style="width: <?php echo $porcentagem_xp ?>%"> <?php echo "{$_SESSION['xp']}/{$_SESSION['xp_max']}" ?></div>
            </div>
            <br><br><br>
            <p id="lista_atributos">NICK - <?php echo $_SESSION['nick'] ?></p>
            <br>
            <p id="lista_atributos">LEVEL - <?php echo $_SESSION['lv'] ?></p>
            <br>
            <p id="lista_atributos">STA - <?php echo $_SESSION['sta'] ?></p>
            <br>
            <p id="lista_atributos">STR - <?php echo $_SESSION['str'] ?></p>
            <br>
            <p id="lista_atributos">INT - <?php echo $_SESSION['int'] ?></p>
            <br>
            <p id="lista_atributos">DEX - <?php echo $_SESSION['dex'] ?></p>

        </div>

    </div>
    <div id="selecao_item">
    <div id='texto_inventario'>Inventario</div>
    <?php 
        $i=1;
        $sql = "SELECT i.id_item, i.nm_item, i.lv, i.valor, i.id_classe, `sta`, `str`, `int`, `dex` 
                FROM rpg.inventarios iv
                    JOIN rpg.itens i ON i.id_item = iv.id_item 
                    JOIN rpg.atributos a ON i.id_item = a.id_item
                    JOIN rpg.classes c ON c.id_classe = i.id_classe
                    JOIN rpg.personagens p ON p.id_classe = c.id_classe
                WHERE p.id_personagem = '{$_SESSION['id_personagem']}'
                    AND iv.slot IS NOT NULL";
        $resultado = mysqli_query($conexao,$sql);
        while ($info_item = mysqli_fetch_assoc($resultado))
        {
            $slot[$i]['id_item'] = $info_item['id_item'];
            $slot[$i]['nm_item'] = $info_item['nm_item'];
            $slot[$i]['lv'] = $info_item['lv'];
            $slot[$i]['valor'] = $info_item['valor'];
            $slot[$i]['id_classe'] = $info_item['id_classe'];
            $slot[$i]['sta'] = $info_item['sta'];
            $slot[$i]['str'] = $info_item['str'];
            $slot[$i]['int'] = $info_item['int'];
            $slot[$i]['dex'] = $info_item['dex'];
            $i++;
        }
        
        ?>

        <div id = '<?php if (isset($slot[1])) echo $slot[1]['nm_item'] ?>' name = 'slot1' class='slot' ></div>
        <div id = '<?php if (isset($slot[2])) echo $slot[2]['nm_item'] ?>' name = 'slot2' class='slot' ></div>
        <div id = '<?php if (isset($slot[3])) echo $slot[3]['nm_item'] ?>' name = 'slot3' class='slot' ></div>
        <div id = '<?php if (isset($slot[4])) echo $slot[4]['nm_item'] ?>' name = 'slot4' class='slot' ></div>
        <div id = '<?php if (isset($slot[5])) echo $slot[5]['nm_item'] ?>' name = 'slot5' class='slot' ></div>
        <div id = '<?php if (isset($slot[6])) echo $slot[6]['nm_item'] ?>' name = 'slot6' class='slot' ></div>
        <div id = '<?php if (isset($slot[7])) echo $slot[7]['nm_item'] ?>' name = 'slot7' class='slot' ></div>
        <div id = '<?php if (isset($slot[8])) echo $slot[8]['nm_item'] ?>' name = 'slot8' class='slot' ></div>
        <div id = '<?php if (isset($slot[9])) echo $slot[9]['nm_item'] ?>' name = 'slot9' class='slot' ></div>
        <div id = '<?php if (isset($slot[10])) echo $slot[10]['nm_item'] ?>' name = 'slot10' class='slot' ></div>
        <div id = '<?php if (isset($slot[11])) echo $slot[11]['nm_item'] ?>' name = 'slot11' class='slot' ></div>
        <div id = '<?php if (isset($slot[12])) echo $slot[12]['nm_item'] ?>' name = 'slot12' class='slot' ></div>
        <div id = '<?php if (isset($slot[13])) echo $slot[13]['nm_item'] ?>' name = 'slot13' class='slot' ></div>
        <div id = '<?php if (isset($slot[14])) echo $slot[14]['nm_item'] ?>' name = 'slot14' class='slot' ></div>
        <div id = '<?php if (isset($slot[15])) echo $slot[15]['nm_item'] ?>' name = 'slot15' class='slot' ></div>
        <div id = '<?php if (isset($slot[16])) echo $slot[16]['nm_item'] ?>' name = 'slot16' class='slot' ></div>
        <div id = '<?php if (isset($slot[17])) echo $slot[17]['nm_item'] ?>' name = 'slot17' class='slot' ></div>
        <div id = '<?php if (isset($slot[18])) echo $slot[18]['nm_item'] ?>' name = 'slot18' class='slot' ></div>


    </div>
    <?php

    ?>
    <div id="informacoes_item">
        <p><?php if (isset($slot[1])) echo $slot[1]['nm_item'] ?></p>
        <p>LEVEL - <?php if (isset($slot[1])) echo $slot[1]['lv'] ?></p>
        <p>STA - <?php if (isset($slot[1])) echo $slot[1]['sta'] ?></p>
        <p>STR - <?php if (isset($slot[1])) echo $slot[1]['str'] ?></p>
        <p>INT - <?php if (isset($slot[1])) echo $slot[1]['int'] ?></p>
        <p>DEX - <?php if (isset($slot[1])) echo $slot[1]['dex'] ?></p>   
    </div>

        <script src = "../js/jquery.js"></script>
        <script src = "../js/ajax.js"></script>
    

