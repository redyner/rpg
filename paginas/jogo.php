<?php
        include "conexao.php";
        $porcentagem_xp = $_SESSION['xp']*100/$_SESSION['xp_max'];
        if ($porcentagem_xp<0) $porcentagem_xp = 0;

    ?>
    
    <div id="painel_principal">
    <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpg"> Página Inicial</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
                <li id="gold" style="float: right;">GOLD - <?php echo $_SESSION['gold']?></li>
            </ul>
        </nav>

        <div id="painel_personagem">
        
        <a href="" ><div class="avatar_personagem_selecao" id = "<?php echo $_SESSION['classe'] ?>"></div></a>
        <div id="atributos_personagem">
        <br><p id="atributo_xp">EXP</p>
        <div class="barra" id="barra_xp">
                <div  id="xp_atual" style="width: <?php echo $porcentagem_xp?>%" > <?php echo "{$_SESSION['xp']}/{$_SESSION['xp_max']}" ?></div>
        </div>
        <br><br><br><p id="lista_atributos">NICK - <?php echo $_SESSION['nick']?></p>
        <br><p id="lista_atributos">LEVEL - <?php echo $_SESSION['lv']?></p>
        <br><p id="lista_atributos">STA - <?php echo $_SESSION['sta']?></p>
        <br><p id="lista_atributos">STR - <?php echo $_SESSION['str']?></p>
        <br><p id="lista_atributos">INT - <?php echo $_SESSION['int']?></p>
        <br><p id="lista_atributos">DEX - <?php echo $_SESSION['dex']?></p> 

        </div>

        </div>
        <div id="selecao_inimigo">
        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo_selecao" id="Javali"></span></a>
        <a href="?pagina=batalha&id=2" ><div class="avatar_inimigo_selecao" id="Urso"></div></a>
        <a href="?pagina=batalha&id=3" ><div class="avatar_inimigo_selecao" id="Lobo"></div></a>
        <a href="?pagina=batalha&id=4" ><div class="avatar_inimigo_selecao" id="Drag"></div></a>
        </div>
         </div>