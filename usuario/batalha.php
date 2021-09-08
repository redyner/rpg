<?php
        include "conexao.php";
        $id_player = $_SESSION['usuario'];
        $classe = $_SESSION['classe'];
        $lv = $_SESSION['lv'];
        $xp = $_SESSION['xp'];
        $xp_max = $_SESSION['xp_max'];
        $sta_personagem = $_SESSION['sta'];
        $atk_personagem = $_SESSION['atk'];
        $def_personagem  = $_SESSION['def'];
        $spd_personagem  = $_SESSION['spd'];
        $crit_personagem = $_SESSION['crit'];
        $porcentagem_xp = $xp*100/$xp_max;
        if ($porcentagem_xp<0) $porcentagem_xp = 0;

        $id = $_GET['id'];
        $sql = "SELECT nick FROM inimigos WHERE id_inimigo = '{$id}'";
        $nick_inimigo = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
        $nick_inimigo = $nick_inimigo['nick'];

    ?>
    
    
    <div id="painel_principal">
    <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpg"> Página Inicial</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
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

    $id = $_GET['id'];
    $sql = "SELECT sta, atk, def, spd FROM rpg.atributos a JOIN rpg.inimigos i ON i.id_inimigo = a.id_inimigo WHERE i.id_inimigo = '{$id}'";
    $atributos_inimigo = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
    $sta_inimigo = $atributos_inimigo['sta'];
    $atk_inimigo = $atributos_inimigo['atk'];
    $def_inimigo  = $atributos_inimigo['def'];
    $spd_inimigo  = $atributos_inimigo['spd'];
    $crit_inimigo = $atributos_inimigo['atk']*2;


if(isset($_POST['atacar']))
{
    $sta_batalha_personagem = $sta_personagem;
    $sta_batalha_inimigo = $sta_inimigo;

    while($sta_batalha_personagem>0&&$sta_batalha_inimigo>0)
    {
        //sleep(1);
        header("Refresh: 20");
        $taxa_crit_personagem = rand(1,100);
        $taxa_crit_inimigo = rand(1,100);

        if($spd_personagem>$spd_inimigo)
        {
            if($taxa_crit_personagem<=$spd_personagem){
            $taxa_bloqueio_inimigo = rand(0,$atributos_inimigo['def']); 
            $dano_final = $crit_personagem - $taxa_bloqueio_inimigo;
            if ($dano_final <0) $dano_final = 0;
            echo "<br><br>você causou {$dano_final} de dano crítico!<br>";
            $sta_batalha_inimigo -= $dano_final;
            $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
            if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
            echo "<div class='barra' id='hp'>
            <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
            </div><br>";
            }else
            {
                $taxa_bloqueio_inimigo = rand(0,$atributos_inimigo['def']); 
                $dano_final = $atk_personagem - $taxa_bloqueio_inimigo;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br>você causou {$dano_final} de dano<br>";
                $sta_batalha_inimigo -= $dano_final;
                $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
                if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
                </div><br>";
            }
            if($taxa_crit_inimigo<=$spd_inimigo&&$sta_batalha_inimigo>0){
                $taxa_bloqueio_personagem = rand(0,$_SESSION['def']); 
                $dano_final = $crit_inimigo - $taxa_bloqueio_personagem;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br>você recebeu {$dano_final} de dano crítico!<br>";
            $sta_batalha_personagem -= $dano_final;
            $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
            if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
            echo "<div class='barra' id='hp'>
            <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
            </div><br>";
            }elseif($sta_batalha_inimigo>0)
            {
                $taxa_bloqueio_personagem = rand(0,$_SESSION['def']); 
                $dano_final = $atributos_inimigo['atk'] - $taxa_bloqueio_personagem;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br>você recebeu {$dano_final} de dano<br>";
                $sta_batalha_personagem -= $dano_final;
                $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                </div><br>";
            }
        }else
        {
            if($taxa_crit_inimigo<=$spd_inimigo&&$sta_batalha_inimigo>0){
                $taxa_bloqueio_personagem = rand(0,$_SESSION['def']); 
                $dano_final = $crit_inimigo - $taxa_bloqueio_personagem;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br>você recebeu {$dano_final} de dano crítico!<br>";
                $sta_batalha_personagem -= $dano_final;
                $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                </div><br>";
                }else
                {
                    $taxa_bloqueio_personagem = rand(0,$_SESSION['def']); 
                    $dano_final = $atributos_inimigo['atk'] - $taxa_bloqueio_personagem;
                    if ($dano_final <0) $dano_final = 0;
                    echo "<br><br>você recebeu {$dano_final} de dano<br>";
                    $sta_batalha_personagem -= $dano_final;
                    $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                    if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                    echo "<div class='barra' id='hp'>
                    <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                    </div><br>";
                }
            if($taxa_crit_personagem<=$spd_personagem&&$sta_batalha_personagem>0){
                $taxa_bloqueio_inimigo = rand(0,$atributos_inimigo['def']); 
                $dano_final = $crit_personagem - $taxa_bloqueio_inimigo;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br>você causou {$dano_final} de dano crítico!<br>";
                $sta_batalha_inimigo -= $dano_final;
                $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
                if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
                </div><br>";
                }elseif($sta_batalha_personagem>0)
                {
                    $taxa_bloqueio_inimigo = rand(0,$atributos_inimigo['def']); 
                    $dano_final = $atk_personagem - $taxa_bloqueio_inimigo;
                    if ($dano_final <0) $dano_final = 0;
                    echo "<br><br>você causou {$dano_final} de dano<br>";
                    $sta_batalha_inimigo -= $dano_final;
                    $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
                    if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
                    echo "<div class='barra' id='hp'>
                    <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
                    </div><br>";
                }
        }
    }

    if($sta_batalha_personagem>0) {
        $sql = "SELECT `xp` FROM inimigos WHERE id_inimigo = '{$id}'";
        $xp_inimigo = mysqli_fetch_array(mysqli_query($conexao,$sql));
        $xp_inimigo = $xp_inimigo['0'];
        $xp += $xp_inimigo;  
        if ($xp >= $xp_max){
            $lv += 1;
            $xp_atual = $xp - $xp_max;  
            $xp = $xp_atual;
            $xp_max = $xp_max * 50 / 100 + $xp_max +100;             
            $sql = "UPDATE `personagens` SET `lv` = {$lv}, `xp_max` = {$xp_max}, `xp` = {$xp}  WHERE id_personagem = '{$id_player}'";
            mysqli_query($conexao,$sql);
            $sql = "SELECT `lv`, `xp`, `xp_max`, `sta` , `atk`, `def` ,`spd`  
            FROM rpg.personagens p
            JOIN rpg.atributos a ON a.id_classe = p.id_classe
            WHERE p.id_personagem = '{$id_player}'";
            $level_up = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
            $_SESSION['lv'] = $level_up['lv'];
            $_SESSION['xp'] = $level_up['xp'];
            $_SESSION['xp_max'] = $level_up['xp_max'];
            $_SESSION['sta'] += $level_up['sta'];
            $_SESSION['atk'] += $level_up['atk'];
            $_SESSION['def'] += $level_up['def'];
            $_SESSION['spd'] += $level_up['spd'];
            $_SESSION['crit'] = $_SESSION['atk']*2;
            echo "<br><br>Parabéns, você subiu de nivel";
        }
        else{
            $sql = "UPDATE `personagens` SET `xp` = {$xp} WHERE id_personagem = '{$id_player}'";
            mysqli_query($conexao,$sql);
            $sql = "SELECT `xp` FROM `personagens` WHERE id_personagem = '{$id_player}'";
            $xp = mysqli_fetch_array(mysqli_query($conexao,$sql));
            $_SESSION['xp'] = $xp['0'];
            echo "<br><br>Você derrotou seu inimigo e ganhou ". $xp_inimigo. " de experiência";
        }            
    }
    else {
        echo "<br><br>Você foi derrotado!";
    }

}
?>
 </div>