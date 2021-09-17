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
            <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
            <li><a href="http://localhost/rpg/teste/teste.php">Teste Eventos</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=batalhajs&id=3">Batalha JS</a></li>
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


        <?php
        $id_personagem = $_SESSION['id_personagem'];

        $sql = "SELECT i.slot, i.refino, i.id_item, i.id_personagem, it.id_item, it.nm_item, 
            it.lv, a.sta, a.str, a.int, a.dex, a.id_item
            FROM rpg.inventarios i 
            JOIN rpg.itens it ON it.id_item = i.id_item
            JOIN rpg.atributos a ON a.id_item = i.id_item
            WHERE i.id_personagem = $id_personagem";
        $quantidade_item = mysqli_num_rows(mysqli_query($conexao, $sql));
        $item_inventario = mysqli_fetch_assoc(mysqli_query($conexao, $sql));
        
        $slot = $item_inventario['slot'];
        $id_item = $item_inventario['id_item'];
        $nm_item = $item_inventario['nm_item'];
        $lv = $item_inventario['lv'];
        $sta = $item_inventario['sta'];
        $str = $item_inventario['str'];
        $int = $item_inventario['int'];
        $dex = $item_inventario['dex'];
        
        ?>
        <div id='texto_inventario'>Inventario</div>
        <?php
        for ($i = 0; $i < $quantidade_item; $i++) { ?>

            <div id="slot" onclick="informacoes_item()" value="<?php echo $nm_item ?>" class='slot'></div>
        <?php } ?>

    </div>
</div>

    <div id="informacoes_item">
        <p><?php echo $nm_item ?></p>
        <p>LEVEL - <?php echo $lv ?></p>
        <p>STA - <?php echo $sta ?></p>
        <p>STR - <?php echo $str ?></p>
        <p>INT - <?php echo $int ?></p>
        <p>DEX - <?php echo $dex ?></p>   
    </div>
        <script>
           // for (var i = 1; i <= 18; i++)
               // document.write("<div onClick='informacoes_item();' id = 'slot"+i+"' class='slot' ></div>")
        </script> -->