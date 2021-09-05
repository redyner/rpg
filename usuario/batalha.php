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
        <a href="" ><div class="avatar_personagem_batalha" id = "<?php echo $classe ?>"></div></a>
        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo_batalha" id="<?php echo $nick_inimigo?>"></span></a>
            <form action="" method="post">
        <input type="submit" name="atacar" value="Atacar" id="sub_atacar">
        </form>
        </div>
<?php
    include "conexao.php";
    $id_player = $_SESSION['usuario'];
    $sql = "SELECT sta, atk, def, spd FROM rpg.personagens WHERE idpersonagem = '{$id_player}'";
    $atributos_personagem = mysqli_fetch_array(mysqli_query($conexao,$sql));
    $sta_personagem = $atributos_personagem['0'];
    $atk_personagem = $atributos_personagem['1'];
    $def_personagem  = $atributos_personagem['2'];
    $spd_personagem  = $atributos_personagem['3'];
    $crit_personagem = $atributos_personagem['atk']*2;

    $id = $_GET['id'];
    $sql = "SELECT sta, atk, def, spd FROM rpg.inimigos WHERE idinimigo = '{$id}'";
    $atributos_inimigo = mysqli_fetch_array(mysqli_query($conexao,$sql));
    $sta_inimigo = $atributos_inimigo['0'];
    $atk_inimigo = $atributos_inimigo['1'];
    $def_inimigo  = $atributos_inimigo['2'];
    $spd_inimigo  = $atributos_inimigo['3'];
    $crit_inimigo = $atributos_inimigo['atk']*2;


if(isset($_POST['atacar']))
{
    $sta_batalha_personagem = $sta_personagem;
    $sta_batalha_inimigo = $sta_inimigo;


    while($sta_batalha_personagem>0&&$sta_batalha_inimigo>0)
    {
        // sleep(2);
        $taxa_crit_personagem = rand(1,100);
        $taxa_crit_inimigo = rand(1,100);

        if($spd_personagem>$spd_inimigo)
        {
            if($taxa_crit_personagem<=$spd_personagem){
            echo "<br><br>você causou {$crit_personagem} de dano crítico!<br>";
            $sta_batalha_inimigo -= $crit_personagem;
            $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
            if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
            echo "<div class='barra' id='hp'>
            <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
            </div><br>";
            }else
            {
                echo "<br><br>você causou {$atk_personagem} de dano<br>";
                $sta_batalha_inimigo -= $atk_personagem;
                $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
                if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
                </div><br>";
            }
            if($taxa_crit_inimigo<=$spd_inimigo&&$sta_batalha_inimigo>0){
            echo "<br><br>você recebeu {$crit_inimigo} de dano crítico!<br>";
            $sta_batalha_personagem -= $crit_inimigo;
            $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
            if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
            echo "<div class='barra' id='hp'>
            <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
            </div><br>";
            }elseif($sta_batalha_inimigo>0)
            {
                echo "<br><br>você recebeu {$atk_inimigo} de dano<br>";
                $sta_batalha_personagem -= $atk_inimigo;
                $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                </div><br>";
            }
        }else
        {
            if($crit_inimigo<=$spd_inimigo&&$sta_batalha_inimigo>0){
                echo "<br><br>você recebeu {$crit_inimigo} de dano crítico!<br>";
                $sta_batalha_personagem -= $crit_inimigo;
                $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                </div><br>";
                }else
                {
                    echo "<br><br>você recebeu {$atk_inimigo} de dano<br>";
                    $sta_batalha_personagem -= $atk_inimigo;
                    $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                    if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                    echo "<div class='barra' id='hp'>
                    <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                    </div><br>";
                }
            if($crit_personagem<=$spd_personagem&&$sta_batalha_personagem>0){
                echo "<br><br>você causou {$crit_personagem} de dano crítico!<br>";
                $sta_batalha_inimigo -= $crit_personagem;
                $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
                if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
                </div><br>";
                }elseif($sta_batalha_personagem>0)
                {
                    echo "<br><br>você causou {$atk_personagem} de dano<br>";
                    $sta_batalha_inimigo -= $atk_personagem;
                    $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
                    if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
                    echo "<div class='barra' id='hp'>
                    <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
                    </div><br>";
                }
        }
    }

    if($sta_batalha_personagem>0) {
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
        echo "<br><br>Você derrotou seu inimigo!";
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
        echo "<br><br>Você foi derrotado!";
    }

}
?>

    </div>