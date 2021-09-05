    <?php
        include "conexao.php";
        $id_player = $_SESSION['usuario'];
        $sql = "SELECT xp, xpmax FROM personagens WHERE idpersonagem = '$id_player'";
        $id_player = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $xp = $id_player['0'];
        $xpmax = $id_player['1'];
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
        <a href="" ><div class="avatar_personagem"></div></a>
            <div class="barra" id="xp">
                <div  id="xp_atual" style="width: <?php echo $porcentagem_xp?>%" > <?php echo "{$xp}/{$xpmax}" ?></div>
            </div>
        </div>
        <div id="selecao_inimigo">
        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo">inimigo 1</span></a>
        <a href="?pagina=batalha&id=2" ><div class="avatar_inimigo" >Inimigo2</div></a>
        <a href="?pagina=batalha&id=3" ><div class="avatar_inimigo" >Inimigo3</div></a>
        </div>
    </div>