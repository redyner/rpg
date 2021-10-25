<?php
include 'functions.php';
$porcentagem_xp = $_SESSION['xp'] * 100 / $_SESSION['xp_max'];
if ($porcentagem_xp < 0) $porcentagem_xp = 0;
?>

<div class="conteudo"">
    <div class=" logo"></div>
<?php include "menu.php" ?>

<div class="painel">
    <div class="avatar" id="avatar_ferreiro"></div>
    <div id='barra_refinar'>
        <div id='refinar_atual'></div>
        <button class="botao" id="botao_refinar">Refinar</button>
        <div id="status_refinar"></div>
        <div id="sucesso"></div>
        <div id="falha"></div>
    </div>
    <img src="http://localhost/rpg/visual/imagens/itens/vazio.png"  class="icone_item" data-id_inventario="" data-equipado="" data-indice="">
</div>

<div class="painel_inferior">
    <div class="titulo">Forja</div>
    <?php
            $slot = preencher_slots("N");
            for ($i = 0; $i <= 14; $i++) {
    ?>

<img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[$i])) echo $slot[$i]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="<?php if (isset($slot[$i])) echo 'slotf' . $i ?>" data-info="<?php if (isset($slot[$i])) echo '#info_slotf' . $i ?>" data-id_inventario="<?php if (isset($slot[$i]['id_inventario'])) echo $slot[$i]['id_inventario'] ?>" data-indice="<?php if (isset($slot[$i])) echo $i ?>" name='<?php if (isset($slot[$i])) echo $slot[$i]['nm_item'] ?>' class="<?php echo isset($slot[$i]) ? 'slotf' : 'slot_empty' ?>">

    <?php } ?>
</div>

<?php
for ($i = 0; $i <= 14; $i++) {
?>

    <div id="info_slotf<?php echo $i ?>" class="informacoes_item">
        <p><?php echo isset($slot[$i]) ? $slot[$i]['nm_item'] : 0 ?></p>
        <p>LEVEL - <?php echo isset($slot[$i]) ? $slot[$i]['lv'] : 0 ?></p>
        <p id="ref_sta<?php echo $i ?>">STA - <?php echo isset($slot[$i]) ? $slot[$i]['sta'] : 0 ?></p>
        <p id="ref_str<?php echo $i ?>">STR - <?php echo isset($slot[$i]) ? $slot[$i]['str'] : 0 ?></p>
        <p id="ref_int<?php echo $i ?>">INT - <?php echo isset($slot[$i]) ? $slot[$i]['int'] : 0 ?></p>
        <p id="ref_dex<?php echo $i ?>">DEX - <?php echo isset($slot[$i]) ? $slot[$i]['dex'] : 0 ?></p>
        <p id="ref_ref<?php echo $i ?>">REF - <?php echo isset($slot[$i]) ? $slot[$i]['ref'] : 0 ?></p>
        <p>VALOR - <?php echo isset($slot[$i]) ? valorPontos($slot[$i]['valor']) : 0 ?></p>
    </div>
<?php } ?>
</div>