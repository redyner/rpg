<?php
include 'functions.php';
$porcentagem_xp = $_SESSION['xp'] * 100 / $_SESSION['xp_max'];
if ($porcentagem_xp < 0) $porcentagem_xp = 0;
?>

<?php
$slot = preencher_slots("S");
?>

<div class="conteudo" id="conteudo">
    <div class="logo"></div>

    <?php include "menu.php" ?>

    <div class="painel">
        <div id="itens_equipados">
            <div id="armadura">
                <div id="slote5d" class="item_equipado" name="Elmo"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[4])) echo $slot[4]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote5" data-info="<?php if (isset($slot[4])) echo '#info_sloti4' ?>" data-id_inventario="<?php if (isset($slot[4]['id_inventario'])) echo $slot[4]['id_inventario'] ?>" data-indice="<?php echo 4 ?>"  class="<?php echo isset($slot[4]) ? 'slote' : 'slote_empty' ?>"> </div>
                <div id="slote6d" class="item_equipado" name="Couraça"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[5])) echo $slot[5]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote6" data-info="<?php if (isset($slot[5])) echo '#info_sloti5' ?>" data-id_inventario="<?php if (isset($slot[5]['id_inventario'])) echo $slot[5]['id_inventario'] ?>" data-indice="<?php echo 5 ?>" class="<?php echo isset($slot[5]) ? 'slote' : 'slote_empty' ?>"> </div>
                <div id="slote7d" class="item_equipado" name="Luvas"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[6])) echo $slot[6]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote7" data-info="<?php if (isset($slot[6])) echo '#info_sloti6' ?>" data-id_inventario="<?php if (isset($slot[6]['id_inventario'])) echo $slot[6]['id_inventario'] ?>" data-indice="<?php echo 6 ?>" class="<?php echo isset($slot[6]) ? 'slote' : 'slote_empty' ?>"> </div>
                <div id="slote8d" class="item_equipado" name="Calça"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[7])) echo $slot[7]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote8" data-info="<?php if (isset($slot[7])) echo '#info_sloti7' ?>" data-id_inventario="<?php if (isset($slot[7]['id_inventario'])) echo $slot[7]['id_inventario'] ?>" data-indice="<?php echo 7 ?>" class="<?php echo isset($slot[7]) ? 'slote' : 'slote_empty' ?>"> </div>
                <div id="slote9d" class="item_equipado" name="Botas"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[8])) echo $slot[8]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote9" data-info="<?php if (isset($slot[8])) echo '#info_sloti8' ?>" data-id_inventario="<?php if (isset($slot[8]['id_inventario'])) echo $slot[8]['id_inventario'] ?>" data-indice="<?php echo 8 ?>" class="<?php echo isset($slot[8]) ? 'slote' : 'slote_empty' ?>"> </div>
            </div>

            <div id="avatar_personagem" name="<?php echo $_SESSION['classe'] ?>_perfil"></div>

            <div id="arma_joia">                
                <div id="slote4d" class="item_equipado" name="Colar"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[3])) echo $slot[3]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote4" data-info="<?php if (isset($slot[3])) echo '#info_sloti3' ?>" data-id_inventario="<?php if (isset($slot[3]['id_inventario'])) echo $slot[3]['id_inventario'] ?>" data-indice="<?php echo 3 ?>" class="<?php echo isset($slot[3]['id_inventario']) ? 'slote' : 'slote_empty' ?>"> </div>
                <div id="slote3d" class="item_equipado" name="Anel"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[2])) echo $slot[2]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote3" data-info="<?php if (isset($slot[2])) echo '#info_sloti2' ?>" data-id_inventario="<?php if (isset($slot[2]['id_inventario'])) echo $slot[2]['id_inventario'] ?>" data-indice="<?php echo 2 ?>" class="<?php echo isset($slot[2]['id_inventario']) ? 'slote' : 'slote_empty' ?>"> </div>
                <div id="slote1d" class="item_equipado" name="Arma"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[0])) echo $slot[0]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote1" data-info="<?php if (isset($slot[0])) echo '#info_sloti0' ?>" data-id_inventario="<?php if (isset($slot[0]['id_inventario'])) echo $slot[0]['id_inventario'] ?>" data-indice="<?php echo 0 ?>" class="<?php echo isset($slot[0]['id_inventario']) ? 'slote' : 'slote_empty' ?>"> </div>
                <div id="slote2d" class="item_equipado" name="Escudo"><img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[1])) echo $slot[1]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="slote2" data-info="<?php if (isset($slot[1])) echo '#info_sloti1' ?>" data-id_inventario="<?php if (isset($slot[1]['id_inventario'])) echo $slot[1]['id_inventario'] ?>" data-indice="<?php echo 1 ?>" class="<?php echo isset($slot[1]['id_inventario']) ? 'slote' : 'slote_empty' ?>"> </div>
            </div>
        </div>
        <div class="painel_infor">
            <p class="titulo">EXP</p>
            <div class="barra" id="barra_xp">
                <div id="xp_xpmax"><?php echo $_SESSION['xp'] . "/" . $_SESSION['xp_max']; ?></div>
                <div id="xp_atual" style="width: <?php echo $porcentagem_xp ?>%"></div>
            </div>
            <div id="informacao_personagem">
                <p id="nick_personagem">NICK - <?php echo $_SESSION['nick'] ?></p>
                <p id="lv_personagem">LEVEL - <?php echo $_SESSION['lv'] ?></p>
                <p id="sta_personagem">STA - <?php echo $_SESSION['sta'] ?></p>
                <p id="str_personagem">STR - <?php echo $_SESSION['str'] ?></p>
                <p id="int_personagem">INT - <?php echo $_SESSION['int'] ?></p>
                <p id="dex_personagem">DEX - <?php echo $_SESSION['dex'] ?></p>
            </div>
        </div>

    </div>
    <hr>
    <div class="painel_inferior">
        <div class="inventario">
            <div class="titulo">Inventario</div>
            <?php
            $slot = preencher_slots("N",9,$slot);
            for ($i = 9; $i <= 23; $i++) {
            ?>
                <img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[$i])) echo $slot[$i]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="<?php if (isset($slot[$i])) echo 'sloti' . $i ?>" data-info="<?php if (isset($slot[$i])) echo '#info_sloti' . $i ?>" data-id_inventario="<?php if (isset($slot[$i]['id_inventario'])) echo $slot[$i]['id_inventario'] ?>" data-indice="<?php echo $i ?>"  class="<?php echo isset($slot[$i]) ? 'slot' : 'slot_empty' ?>" <?php if (isset($slot[$i]['equipado']) && $slot[$i]['equipado'] == 'S') echo "style='border: 5px solid grey'" ?>>
            <?php } ?>
        </div>
    </div>

    <?php
    for ($i = 0; $i <= 23; $i++) {
    ?>
        <div id="info_sloti<?php echo $i ?>" class="informacoes_item">
            <p class="titulo" style="margin-bottom: 5%;"><?php echo isset($slot[$i]) ? $slot[$i]['nm_item'] : 0 ?></p>
            <p>LEVEL - <?php echo isset($slot[$i]) ? $slot[$i]['lv'] : 0 ?></p>
            <p>STA - <?php echo isset($slot[$i]) ? $slot[$i]['sta'] : 0 ?></p>
            <p>STR - <?php echo isset($slot[$i]) ? $slot[$i]['str'] : 0 ?></p>
            <p>INT - <?php echo isset($slot[$i]) ? $slot[$i]['int'] : 0 ?></p>
            <p>DEX - <?php echo isset($slot[$i]) ? $slot[$i]['dex'] : 0 ?></p>
            <p>REF - <?php echo isset($slot[$i]) ? $slot[$i]['ref'] : 0 ?></p>
            <p>Valor <?php echo isset($slot[$i]) ? valorPontos($slot[$i]['valor']) : 0 ?></p>
        </div>

    <?php } ?>

    <script>
        var slot = [
            <?php
            for ($i = 0; $i <= 13; $i++) {
            ?>[<?php echo isset($slot[$i]) ? $slot[$i]['id_inventario'] : 0 ?>, "<?php echo isset($slot[$i]) ? $slot[$i]['equipado'] : 0 ?>"],
            <?php
            }
            ?>[<?php echo isset($slot[15]) ? $slot[15]['id_inventario'] : 0 ?>, "<?php echo isset($slot[15]) ? $slot[15]['equipado'] : 0 ?>"]
        ]
    </script>
    
    <script src="../js/jquery.js"></script>
</div>