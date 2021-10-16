<?php
include 'functions.php';
$porcentagem_xp = $_SESSION['xp'] * 100 / $_SESSION['xp_max'];
if ($porcentagem_xp < 0) $porcentagem_xp = 0;
?>

<div class="conteudo" id="conteudo">
    <div class="logo"></div>

    <?php include "menu.php" ?>

    <div class="painel">
        <div class="avatar" name="<?php echo $_SESSION['classe'] ?>"></div>
        <div class="painel_infor">
            <p class="titulo">EXP</p>
            <div class="barra" id="barra_xp">
                <div id="xp_xpmax"><?php echo $_SESSION['xp'] . "/" . $_SESSION['xp_max']; ?></div>
                <div id="xp_atual" style="width: <?php echo $porcentagem_xp ?>%"></div>
            </div>
            <p id="nick_personagem">NICK - <?php echo $_SESSION['nick'] ?></p>
            <p id="lv_personagem">LEVEL - <?php echo $_SESSION['lv'] ?></p>
            <p id="sta_personagem">STA - <?php echo $_SESSION['sta'] ?></p>
            <p id="str_personagem">STR - <?php echo $_SESSION['str'] ?></p>
            <p id="int_personagem">INT - <?php echo $_SESSION['int'] ?></p>
            <p id="dex_personagem">DEX - <?php echo $_SESSION['dex'] ?></p>
        </div>
    </div>
    <hr>
    <div class="painel_inferior">
        <div class="inventario">
            <div class="titulo">Inventario</div>
            <?php
            $i = 0;
            $sql = "SELECT i.id_item, i.nm_item, i.lv, i.valor, i.id_classe, `sta`, `str`, `int`, `dex`, iv.equipado, iv.id_inventario, refino
                FROM rpg.inventarios iv
                JOIN rpg.itens i ON i.id_item = iv.id_item 
                JOIN rpg.atributos a ON i.id_item = a.id_item
                JOIN rpg.personagens p ON p.id_personagem = iv.id_personagem
                WHERE p.id_personagem = '{$_SESSION['id_personagem']}'
                ORDER BY iv.slot";
            $resultado = mysqli_query($conexao, $sql);
            while ($info_item = mysqli_fetch_assoc($resultado)) {
                $slot[$i]['id_item'] = $info_item['id_item'];
                $slot[$i]['nm_item'] = $info_item['nm_item'];
                $slot[$i]['lv'] = $info_item['lv'];
                $slot[$i]['valor'] = $info_item['valor'];
                $slot[$i]['id_classe'] = $info_item['id_classe'];
                $slot[$i]['sta'] = $info_item['sta'] * ($info_item['refino'] + 1);
                $slot[$i]['str'] = $info_item['str'] * ($info_item['refino'] + 1);
                $slot[$i]['int'] = $info_item['int'] * ($info_item['refino'] + 1);
                $slot[$i]['dex'] = $info_item['dex'] * ($info_item['refino'] + 1);
                $slot[$i]['ref'] = $info_item['refino'];
                $slot[$i]['equipado'] = $info_item['equipado'];
                $slot[$i]['id_inventario'] = $info_item['id_inventario'];
                $i++;
            }

            for ($i = 0; $i <= 14; $i++) {
            ?>
                <div id="<?php if (isset($slot[$i])) echo 'sloti' . $i ?>" data-info="<?php if (isset($slot[$i])) echo '#info_sloti' . $i ?>" data-id_inventario="<?php if (isset($slot[$i]['id_inventario'])) echo $slot[$i]['id_inventario'] ?>" data-indice="<?php echo $i ?>" name='<?php if (isset($slot[$i])) echo $slot[$i]['nm_item'] ?>' class="<?php echo isset($slot[$i]) ? 'slot' : 'slot_empty' ?>" <?php if (isset($slot[$i]['equipado']) && $slot[$i]['equipado'] == 'S') echo "style='border: 5px solid grey'" ?>></div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php
    for ($i = 0; $i <= 14; $i++) {
    ?>
        <div id="info_sloti<?php echo $i ?>" class="informacoes_item">
            <p class="titulo" style="margin-bottom: 5%;"><?php echo isset($slot[$i]) ? $slot[$i]['nm_item'] : 0 ?></p>
            <p>LEVEL - <?php echo isset($slot[$i]) ? $slot[$i]['lv'] : 0 ?></p>
            <p>STA - <?php echo isset($slot[$i]) ? $slot[$i]['sta'] : 0 ?></p>
            <p>STR - <?php echo isset($slot[$i]) ? $slot[$i]['str'] : 0 ?></p>
            <p>INT - <?php echo isset($slot[$i]) ? $slot[$i]['int'] : 0 ?></p>
            <p>DEX - <?php echo isset($slot[$i]) ? $slot[$i]['dex'] : 0 ?></p>
            <p>REF - <?php echo isset($slot[$i]) ? $slot[$i]['ref'] : 0 ?></p>
            <p>Valor <?php echo isset($slot[$i]) ? $slot[$i]['valor'] : 0 ?></p>
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
    <script src="../js/ajax.js"></script>

</div>