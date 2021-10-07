<?php
include 'functions.php';
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
            <li><a href="http://localhost/rpg/index.php?pagina=arena">Arena</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
            <li id="gold" style="float: right;">GOLD - <?php echo $_SESSION['gold'] ?></li>
        </ul>
    </nav>

    <div id="painel_personagem">

            <div class="avatar_npc" id="ferreiro"></div>
            <button id="refinar">Refinar</button>
        <div class="avatar_item" ></div>

    </div>
    <div id="selecao_item">
    <div id='texto_inventario'>Forja</div>
    <?php 
        $i=0;
        $sql = "SELECT i.id_item, i.nm_item, i.lv, i.valor, i.id_classe, `sta`, `str`, `int`, `dex`, iv.equipado, iv.id_inventario, refino
                FROM rpg.inventarios iv
                    JOIN rpg.itens i ON i.id_item = iv.id_item 
                    JOIN rpg.atributos a ON i.id_item = a.id_item
                    JOIN rpg.personagens p ON p.id_personagem = iv.id_personagem
                WHERE p.id_personagem = '{$_SESSION['id_personagem']}'
                    ORDER BY iv.slot";
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
            $slot[$i]['ref'] = $info_item['refino'];
            $slot[$i]['equipado'] = $info_item['equipado'];
            $slot[$i]['id_inventario'] = $info_item['id_inventario'];
            $i++;
        }
        
        ?>
    <?php
        for($i=0;$i<=14;$i++){
    ?>

        <div id = 'sloti<?php if (isset($slot[$i])) echo $i ?>' name = '<?php if (isset($slot[$i])) echo $slot[$i]['nm_item'] ?>'  class='slot'  <?php if (isset($slot[$i]['equipado']) && $slot[$i]['equipado'] == 'S') echo "style='border: 5px solid red'" ?> ></div>
    
    <?php
        }
    ?>

    </div>
  
    <?php
        for($i=0;$i<=14;$i++){
    ?>
    
    <div id="info_sloti<?php echo $i ?>" class="informacoes_item">
        <p><?php echo isset($slot[$i]) ? $slot[$i]['nm_item'] : 0?></p>
        <p>LEVEL - <?php echo isset($slot[$i]) ? $slot[$i]['lv'] : 0 ?></p>
        <p>STA - <?php echo isset($slot[$i]) ? $slot[$i]['sta'] : 0 ?></p>
        <p>STR - <?php echo isset($slot[$i]) ? $slot[$i]['str'] : 0 ?></p>
        <p>INT - <?php echo isset($slot[$i]) ? $slot[$i]['int'] : 0 ?></p>
        <p>DEX - <?php echo isset($slot[$i]) ? $slot[$i]['dex'] : 0 ?></p>   
        <p>REF - <?php echo isset($slot[$i]) ? $slot[$i]['ref'] : 0 ?></p>    
        <p>VALOR - <?php echo isset($slot[$i]) ? $slot[$i]['valor'] : 0 ?></p>  
    </div>

    <?php
        }
    ?>

    <script>

        var slot = [
            <?php
            for($i=0;$i<=13;$i++){
            ?>
            [<?php echo isset($slot[$i]) ? $slot[$i]['id_inventario'] : 0 ?>, "<?php echo isset($slot[$i]) ? $slot[$i]['equipado'] : 0 ?>"],
            <?php
            }
            ?>   
            [<?php echo isset($slot[15]) ? $slot[15]['id_inventario'] : 0 ?>,"<?php echo isset($slot[15]) ? $slot[15]['equipado'] : 0 ?>"]
        ]

    </script>