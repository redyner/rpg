<?php
        include "conexao.php";
        $id_player = $_SESSION['usuario'];
        $sql = "SELECT xp, xpmax, classe FROM personagens WHERE idpersonagem = '$id_player'";
        $id_player = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $id = $_GET['id'];
        $sql = "SELECT nick FROM inimigos WHERE idinimigo = '{$id}'";
        $nick_inimigo = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $nick_inimigo = $nick_inimigo['0'];
        $xp = $id_player['0'];
        $xpmax = $id_player['1'];
        $classe = $id_player['2'];
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

        <div id="painel_batalha">
        <a href="" ><div class="avatar_personagem" id = "<?php echo $classe ?>"></div></a>
        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo" id="<?php echo $nick_inimigo?>"></span></a>
            <form action="" method="post">
        <input type="submit" name="atacar" value="Atacar" id="sub_atacar">
        </form>
        </div>
<?php
    include "conexao.php";
    $id_player = $_SESSION['usuario'];
    $sql = "SELECT hp, atk, def, spd FROM rpg.personagens WHERE idpersonagem = '{$id_player}'";
    $atributos_personagem = mysqli_fetch_array(mysqli_query($conexao,$sql));
    $hp_personagem = $atributos_personagem['0'];
    $atk_personagem = $atributos_personagem['1'];
    $def_personagem  = $atributos_personagem['2'];
    $spd_personagem  = $atributos_personagem['3'];
    $crit_personagem = $atributos_personagem['atk']*2;

    $id = $_GET['id'];
    $sql = "SELECT hp, atk, def, spd FROM rpg.inimigos WHERE idinimigo = '{$id}'";
    $atributos_inimigo = mysqli_fetch_array(mysqli_query($conexao,$sql));
    $hp_inimigo = $atributos_inimigo['0'];
    $atk_inimigo = $atributos_inimigo['1'];
    $def_inimigo  = $atributos_inimigo['2'];
    $spd_inimigo  = $atributos_inimigo['3'];
    $crit_inimigo = $atributos_inimigo['atk']*2;


if(isset($_POST['atacar']))
{
    $hp_batalha_personagem = $hp_personagem;
    $hp_batalha_inimigo = $hp_inimigo;


    while($hp_batalha_personagem>0&&$hp_batalha_inimigo>0)
    {
        // sleep(2);
        $taxa_crit_personagem = rand(1,100);
        $taxa_crit_inimigo = rand(1,100);

        if($spd_personagem>$spd_inimigo)
        {
            if($taxa_crit_personagem<=$spd_personagem){
            echo "<br>você causou {$crit_personagem} de dano crítico!<br>";
            $hp_batalha_inimigo -= $crit_personagem;
            $porcentagem_hp_inimigo = $hp_batalha_inimigo*100/$hp_inimigo;
            if ($porcentagem_hp_inimigo<0) $porcentagem_hp_inimigo = 0;
            echo "<div class='barra' id='hp'>
            <div  id='hp_atual' style='width: {$porcentagem_hp_inimigo}%' > {$hp_batalha_inimigo}/{$hp_inimigo} </div>
            </div><br>";
            }else
            {
                echo "<br>você causou {$atk_personagem} de dano<br>";
                $hp_batalha_inimigo -= $atk_personagem;
                $porcentagem_hp_inimigo = $hp_batalha_inimigo*100/$hp_inimigo;
                if ($porcentagem_hp_inimigo<0) $porcentagem_hp_inimigo = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_hp_inimigo}%' > {$hp_batalha_inimigo}/{$hp_inimigo} </div>
                </div><br>";
            }
            if($taxa_crit_inimigo<=$spd_inimigo&&$hp_batalha_inimigo>0){
            echo "<br>você recebeu {$crit_inimigo} de dano crítico!<br>";
            $hp_batalha_personagem -= $crit_inimigo;
            $porcentagem_hp_personagem = $hp_batalha_personagem*100/$hp_personagem;
            if ($porcentagem_hp_personagem<0) $porcentagem_hp_personagem = 0;
            echo "<div class='barra' id='hp'>
            <div  id='hp_atual' style='width: {$porcentagem_hp_personagem}%' > {$hp_batalha_personagem}/{$hp_personagem} </div>
            </div><br>";
            }elseif($hp_batalha_inimigo>0)
            {
                echo "<br>você recebeu {$atk_inimigo} de dano<br>";
                $hp_batalha_personagem -= $atk_inimigo;
                $porcentagem_hp_personagem = $hp_batalha_personagem*100/$hp_personagem;
                if ($porcentagem_hp_personagem<0) $porcentagem_hp_personagem = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_hp_personagem}%' > {$hp_batalha_personagem}/{$hp_personagem} </div>
                </div><br>";
            }
        }else
        {
            if($crit_inimigo<=$spd_inimigo&&$hp_batalha_inimigo>0){
                echo "<br>você recebeu {$crit_inimigo} de dano crítico!<br>";
                $hp_batalha_personagem -= $crit_inimigo;
                $porcentagem_hp_personagem = $hp_batalha_personagem*100/$hp_personagem;
                if ($porcentagem_hp_personagem<0) $porcentagem_hp_personagem = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_hp_personagem}%' > {$hp_batalha_personagem}/{$hp_personagem} </div>
                </div><br>";
                }else
                {
                    echo "<br>você recebeu {$atk_inimigo} de dano<br>";
                    $hp_batalha_personagem -= $atk_inimigo;
                    $porcentagem_hp_personagem = $hp_batalha_personagem*100/$hp_personagem;
                    if ($porcentagem_hp_personagem<0) $porcentagem_hp_personagem = 0;
                    echo "<div class='barra' id='hp'>
                    <div  id='hp_atual' style='width: {$porcentagem_hp_personagem}%' > {$hp_batalha_personagem}/{$hp_personagem} </div>
                    </div><br>";
                }
            if($crit_personagem<=$spd_personagem&&$hp_batalha_personagem>0){
                echo "<br>você causou {$crit_personagem} de dano crítico!<br>";
                $hp_batalha_inimigo -= $crit_personagem;
                $porcentagem_hp_inimigo = $hp_batalha_inimigo*100/$hp_inimigo;
                if ($porcentagem_hp_inimigo<0) $porcentagem_hp_inimigo = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_hp_inimigo}%' > {$hp_batalha_inimigo}/{$hp_inimigo} </div>
                </div><br>";
                }elseif($hp_batalha_personagem>0)
                {
                    echo "<br>você causou {$atk_personagem} de dano<br>";
                    $hp_batalha_inimigo -= $atk_personagem;
                    $porcentagem_hp_inimigo = $hp_batalha_inimigo*100/$hp_inimigo;
                    if ($porcentagem_hp_inimigo<0) $porcentagem_hp_inimigo = 0;
                    echo "<div class='barra' id='hp'>
                    <div  id='hp_atual' style='width: {$porcentagem_hp_inimigo}%' > {$hp_batalha_inimigo}/{$hp_inimigo} </div>
                    </div><br>";
                }
        }
    }

    if($hp_batalha_personagem>0) {
        $id_player = $_SESSION['usuario'];
        $sql = "SELECT xp, xpmax FROM personagens WHERE idpersonagem = '{$id_player}'";
        $xp_player = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $xp_atual = $xp_player['0'];
        $xpmax = $xp_player['1'];
        $sql = "SELECT `xp` FROM inimigos WHERE idinimigo = '{$id}'";
        $xp = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $xp = $xp['0'];
        $xp_atual += $xp;
        $sql = "UPDATE `personagens` SET `xp` = {$xp_atual} WHERE idpersonagem = '{$id_player}'";
        mysqli_query($conexao,$sql);
        echo "<br>Você derrotou seu inimigo!";
    }
    else {
        $id_player = $_SESSION['usuario'];
        $sql = "SELECT xp, xpmax FROM personagens WHERE idpersonagem = '{$id_player}'";
        $xp_player = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $xp_atual = $xp_player['0'];
        $xpmax = $xp_player['1'];
        $sql = "SELECT `xp` FROM inimigos WHERE idinimigo = '{$id}'";
        $xp = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $xp = $xp['0'];
        $xp_atual -= $xp;
        $sql = "UPDATE `personagens` SET `xp` = {$xp_atual} WHERE idpersonagem = '{$id_player}'";
        mysqli_query($conexao,$sql);
        echo "<br>Você foi derrotado!";
    }

}
?>

    </div>