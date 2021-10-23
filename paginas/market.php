<?php
include 'functions.php';
$porcentagem_xp = $_SESSION['xp'] * 100 / $_SESSION['xp_max'];
if ($porcentagem_xp < 0) $porcentagem_xp = 0;

?>

<div class="conteudo">
    <div class="logo"></div>
    <?php include "menu.php" ?>
    <div class="painel"">
        <div class=" avatar" id="mercador"></div>
        <button class="botao" id="vendercomprar">Vender</button>
        <div class="icone_item" data-id_inventario="" data-equipado="" data-indice="">
        </div>

</div>
<div class="painel_inferior">
    <div class="titulo">Market</div>
    <div id="comprar_item" class="invetario">
        <?php
        $i = 0;
        $sql = "SELECT i.id_item, i.imagem, i.nm_item, i.lv, i.valor, i.id_classe, `sta`, `str`, `int`, `dex`
                FROM rpg.itens i
                    JOIN rpg.atributos a ON i.id_item = a.id_item
                    JOIN rpg.classes c ON c.id_classe = i.id_classe";
        $resultado = mysqli_query($conexao, $sql);
        while ($info_item = mysqli_fetch_assoc($resultado)) {
            $slot[$i]['id_item'] = $info_item['id_item'];
            $slot[$i]['imagem'] = $info_item['imagem'];
            $slot[$i]['nm_item'] = $info_item['nm_item'];
            $slot[$i]['lv'] = $info_item['lv'];
            $slot[$i]['valor'] = $info_item['valor'];
            $slot[$i]['id_classe'] = $info_item['id_classe'];
            $slot[$i]['sta'] = $info_item['sta'];
            $slot[$i]['str'] = $info_item['str'];
            $slot[$i]['int'] = $info_item['int'];
            $slot[$i]['dex'] = $info_item['dex'];
            $slot[$i]['ref'] = 0;
            $i++;
        }
      
        for ($i = 0; $i <= 14; $i++) {
        ?>
            <img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[$i])) echo $slot[$i]['imagem']; else echo "vazio.png";?>" style="background-size: contain;"  id="<?php if (isset($slot[$i])) echo 'slotm' . $i ?>" data-info="<?php if (isset($slot[$i])) echo '#info_slotm' . $i ?>" data-id_inventario="<?php if (isset($slot[$i]['id_inventario'])) echo $slot[$i]['id_inventario'] ?>" data-indice="<?php echo $i ?>" name='<?php if (isset($slot[$i])) echo $slot[$i]['nm_item'] ?>' class="<?php echo isset($slot[$i]) ? 'slotm' : 'slot_empty' ?>">
        <?php  } ?>
    </div>
    <div id="vender_item">
    <?php
            $slot = preencher_slots("N");
            for ($i = 0; $i <= 14; $i++) {
    ?>
            <img src="http://localhost/rpg/visual/imagens/itens/<?php if (isset($slot[$i])) echo $slot[$i]['imagem']; else echo "vazio.png";?>" style="background-size: contain;" id="<?php if (isset($slot[$i])) echo 'slotm' . $i ?>" data-info="<?php if (isset($slot[$i])) echo '#info_slotm' . $i ?>" data-id_inventario="<?php if (isset($slot[$i]['id_inventario'])) echo $slot[$i]['id_inventario'] ?>" data-indice="<?php echo $i ?>" name="<?php echo isset($slot[$i]) ? $slot[$i]['nm_item'] :  $i ?>" class="<?php echo isset($slot[$i]) ? 'slotm' : 'slot_empty' ?>" <?php if (isset($slot[$i]['equipado']) && $slot[$i]['equipado'] == 'S') echo "style='border: 5px solid grey'"?>>
            <?php  } ?>
    </div>
</div>

<?php
for ($i = 0; $i <= 29; $i++) {
?>
    <div id="info_slotm<?php echo $i ?>" class="informacoes_item">
        <p><?php echo isset($slot[$i]) ? $slot[$i]['nm_item'] : 0 ?></p>
        <p>LEVEL - <?php echo isset($slot[$i]) ? $slot[$i]['lv'] : 0 ?></p>
        <p>STA - <?php echo isset($slot[$i]) ? $slot[$i]['sta'] : 0 ?></p>
        <p>STR - <?php echo isset($slot[$i]) ? $slot[$i]['str'] : 0 ?></p>
        <p>INT - <?php echo isset($slot[$i]) ? $slot[$i]['int'] : 0 ?></p>
        <p>DEX - <?php echo isset($slot[$i]) ? $slot[$i]['dex'] : 0 ?></p>
        <p>REF - <?php echo isset($slot[$i]) ? $slot[$i]['ref'] : 0 ?></p>
        <p>VALOR - <?php echo isset($slot[$i]) ? valorPontos($slot[$i]['valor']) : 0 ?></p>
    </div>
<?php  } ?>

<script>
    var slot = [
        <?php
        for ($i = 0; $i <= 27; $i++) {
        ?>[<?php echo isset($slot[$i]) ? $slot[$i]['id_item'] : 0 ?>, "<?php echo isset($slot[$i]) ? $slot[$i]['valor'] : 0 ?>", "<?php echo isset($slot[$i]['id_inventario']) ? $slot[$i]['id_inventario'] : 0 ?>"],
        <?php
        }
        ?>[<?php echo isset($slot[29]) ? $slot[29]['id_item'] : 0 ?>, "<?php echo isset($slot[29]) ? $slot[29]['valor'] : 0 ?>", "<?php echo isset($slot[$i]['id_inventario']) ? $slot[$i]['id_inventario'] : 0 ?>"]
    ]
</script>

<script src="../js/jquery.js"></script>
<script src="../js/ajax.js"></script>
</div>