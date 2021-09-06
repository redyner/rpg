    <?php
        include "conexao.php";
        $id_player = $_SESSION['usuario'];
        $sql = "SELECT xp, xpmax, classe, sta, atk, def, spd, nick FROM personagens WHERE idpersonagem = '$id_player'";
        $id_player = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $xp = $id_player['0'];
        $xpmax = $id_player['1'];
        $classe = $id_player['2'];
        $sta = $id_player['3'];
        $atk = $id_player['4'];
        $def = $id_player['5'];
        $spd = $id_player['6'];
        $nick = $id_player['7'];
        $porcentagem_xp = $xp*100/$xpmax;
        if ($porcentagem_xp<0) $porcentagem_xp = 0;
    ?>
    
    <div id="painel_principal">
    <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpgbrowser"> Página Inicial</a></li>
                <li><a href="http://localhost/rpgbrowser/index.php?pagina=sair">Sair</a></li>
            </ul>
        </nav>

        <div id="painel_personagem">
        
        <a href="" ><div class="avatar_personagem_selecao" id = "<?php echo $classe ?>"></div></a>
        <div id="atributos_personagem">
        <br><p id="atributo_xp">EXP</p>
        <div class="barra" id="barra_xp">
                <div  id="xp_atual" style="width: <?php echo $porcentagem_xp?>%" > <?php echo "{$xp}/{$xpmax}" ?></div>
        </div>
        <br><br><br><p id="lista_atributos">NICK - <?php echo $nick?></p>
        <br><p id="lista_atributos">STA - <?php echo $sta?></p>
        <br><p id="lista_atributos">ATK - <?php echo $atk?></p>
        <br><p id="lista_atributos">DEF - <?php echo $def?></p>
        <br><p id="lista_atributos">SPD - <?php echo $spd?></p>

        </div>

        </div>
        <div id="selecao_inimigo">
        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo_selecao" id="Javali"></span></a>
        <a href="?pagina=batalha&id=2" ><div class="avatar_inimigo_selecao" id="Urso"></div></a>
        <a href="?pagina=batalha&id=3" ><div class="avatar_inimigo_selecao" id="Drag"></div></a>
        </div>
    </div>