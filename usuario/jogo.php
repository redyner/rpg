<?php
        include "conexao.php";
        $id_player = $_SESSION['usuario'];
        $id_personagem = $_SESSION['id_personagem'];
        $nick = $_SESSION['nick'];
        $level = $_SESSION['lv'];
        $xp = $_SESSION['xp'];
        $xp_max = $_SESSION['xp_max'];
        $classe = $_SESSION['classe'];
        $sta = $_SESSION['sta'];
        $atk = $_SESSION['atk'];
        $def = $_SESSION['def'];
        $spd = $_SESSION['spd'];
        $porcentagem_xp = $xp*100/$xp_max;
        if ($porcentagem_xp<0) $porcentagem_xp = 0;

    ?>
    
    <div id="painel_principal">
    <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpg"> Página Inicial</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
            </ul>
        </nav>

        <div id="painel_personagem">
        
        <a href="" ><div class="avatar_personagem_selecao" id = "<?php echo $classe ?>"></div></a>
        <div id="atributos_personagem">
        <br><p id="atributo_xp">EXP</p>
        <div class="barra" id="barra_xp">
                <div  id="xp_atual" style="width: <?php echo $porcentagem_xp?>%" > <?php echo "{$xp}/{$xp_max}" ?></div>
        </div>
        <br><br><br><p id="lista_atributos">NICK - <?php echo $nick?></p>
        <br><p id="lista_atributos">Level - <?php echo $level?></p>
        <br><p id="lista_atributos">STA - <?php echo $sta?></p>
        <br><p id="lista_atributos">ATK - <?php echo $atk?></p>
        <br><p id="lista_atributos">DEF - <?php echo $def?></p>
        <br><p id="lista_atributos">SPD - <?php echo $spd?></p>

        </div>

        </div>
        <div id="selecao_inimigo">
        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo_selecao" id="Javali"></span></a>
        <a href="?pagina=batalha&id=2" ><div class="avatar_inimigo_selecao" id="Urso"></div></a>
        <a href="?pagina=batalha&id=4" ><div class="avatar_inimigo_selecao" id="Lobo"></div></a>
        <a href="?pagina=batalha&id=3" ><div class="avatar_inimigo_selecao" id="Drag"></div></a>
        </div>
         </div>