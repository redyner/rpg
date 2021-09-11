<?php
        include "conexao.php";
        $porcentagem_xp = $_SESSION['xp']*100/$_SESSION['xp_max'];
        if ($porcentagem_xp<0) $porcentagem_xp = 0;

    ?>
    
    <div id="painel_principal">
    <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpg"> Pagina Inicial</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=market">Market</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
                <li id="gold" style="float: right;">GOLD - <?php echo $_SESSION['gold']?></li>
            </ul>
        </nav>

        <div id="painel_personagem">
        
        <div class="dungeon" id = "floresta"></div>
        <div class="dungeon" id = "planice"></div>
        <div class="dungeon" id = "gruta"></div>

        </div>

        <div id="selecao_inimigo">
        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo_selecao" id="Javali"></span></a>
        <a href="?pagina=batalha&id=5" ><div class="avatar_inimigo_selecao" id="Goblin"></div></a>
        <a href="?pagina=batalha&id=2" ><div class="avatar_inimigo_selecao" id="Urso"></div></a>
        <a href="?pagina=batalha&id=6" ><div class="avatar_inimigo_selecao" id="Orc"></div></a>
        <a href="?pagina=batalha&id=3" ><div class="avatar_inimigo_selecao" id="Lobo"></div></a>
        <a href="?pagina=batalha&id=4" ><div class="avatar_inimigo_selecao" id="Drag"></div></a>
        <a href="?pagina=batalha&id=9" ><div class="avatar_inimigo_selecao" id="Cerberus"></div></a>
        <a href="?pagina=batalha&id=8" ><div class="avatar_inimigo_selecao" id="Blue_Drag"></div></a>
        <a href="?pagina=batalha&id=7" ><div class="avatar_inimigo_selecao" id="Boss"></div></a>
        </div>
        </div>
        
        <script>
            document.getElementById("selecao_inimigo").style.display="none"
        </script>

        