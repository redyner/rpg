<?php
        include "conexao.php";
        $id_player = $_SESSION['id_player'];
        $classe = $_SESSION['classe'];
        $lv = $_SESSION['lv'];
        $xp = $_SESSION['xp'];
        $xp_max = $_SESSION['xp_max'];
        $sta_personagem = $_SESSION['sta'];
        $str_personagem = $_SESSION['str'];
        $int_personagem  = $_SESSION['int'];
        $dex_personagem  = $_SESSION['dex'];
        $crit_personagem = $_SESSION['crit'];
        $porcentagem_xp = $xp*100/$xp_max;
        if ($porcentagem_xp<0) $porcentagem_xp = 0;

        $id = $_GET['id'];
        $sql = "SELECT nm_inimigo FROM inimigos WHERE id_inimigo = '{$id}'";
        $nick_inimigo = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
        $nick_inimigo = $nick_inimigo['nm_inimigo'];

    ?>
    
    
    <div id="painel_principal">
    <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpg"> Pagina Inicial</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=dungeon">Dungeons</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=market">Market</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
            </ul>
        </nav>

        <div id="painel_batalha">
        <a href="" ><div class="avatar_personagem_batalha" id = "<?php echo $classe ?>"></div></a>
        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo_batalha" id="<?php echo $nick_inimigo?>"></span></a>
            <form action="" method="post">
        <input type="submit" name="atacar" value="Atacar" id="atacar">
        </form>
        </div>
<?php

    $id = $_GET['id'];
    $sql = "SELECT sta, `str`, `int`, dex FROM rpg.atributos a JOIN rpg.inimigos i ON i.id_inimigo = a.id_inimigo WHERE i.id_inimigo = '{$id}'";
    $atributos_inimigo = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
    $sta_inimigo = $atributos_inimigo['sta'];
    $str_inimigo = $atributos_inimigo['str'];
    $int_inimigo  = $atributos_inimigo['int'];
    $dex_inimigo  = $atributos_inimigo['dex'];
    $crit_inimigo = $atributos_inimigo['str']+$atributos_inimigo['dex']*2;


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

        if($dex_personagem>$dex_inimigo)
        {
            if($taxa_crit_personagem<=$dex_personagem){
            $taxa_bloqueio_inimigo = rand(0,$atributos_inimigo['int']); 
            $dano_final = $crit_personagem - $taxa_bloqueio_inimigo;
            if ($dano_final <0) $dano_final = 0;
            echo "<br><br><p id='fonte_combate'>Voce causou {$dano_final} de dano critico!</p><br>";
            $sta_batalha_inimigo -= $dano_final;
            $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
            if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
            echo "<div class='barra' id='hp'>
            <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
            </div><br>";
            }else
            {
                $taxa_bloqueio_inimigo = rand(0,$atributos_inimigo['int']); 
                $dano_final = $str_personagem - $taxa_bloqueio_inimigo;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br><p id='fonte_combate'>Voce causou {$dano_final} de dano</p><br>";
                $sta_batalha_inimigo -= $dano_final;
                $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
                if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
                </div><br>";
            }
            if($taxa_crit_inimigo<=$dex_inimigo&&$sta_batalha_inimigo>0){
                $taxa_bloqueio_personagem = rand(0,$_SESSION['int']); 
                $dano_final = $crit_inimigo - $taxa_bloqueio_personagem;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br><p id='fonte_combate'>Voce recebeu {$dano_final} de dano critico!</p><br>";
            $sta_batalha_personagem -= $dano_final;
            $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
            if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
            echo "<div class='barra' id='hp'>
            <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
            </div><br>";
            }elseif($sta_batalha_inimigo>0)
            {
                $taxa_bloqueio_personagem = rand(0,$_SESSION['int']); 
                $dano_final = $atributos_inimigo['str'] - $taxa_bloqueio_personagem;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br><p id='fonte_combate'>Voce recebeu {$dano_final} de dano</p><br>";
                $sta_batalha_personagem -= $dano_final;
                $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                </div><br>";
            }
        }else
        {
            if($taxa_crit_inimigo<=$dex_inimigo&&$sta_batalha_inimigo>0){
                $taxa_bloqueio_personagem = rand(0,$_SESSION['int']); 
                $dano_final = $crit_inimigo - $taxa_bloqueio_personagem;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br><p id='fonte_combate'>Voce recebeu {$dano_final} de dano critico!</p><br>";
                $sta_batalha_personagem -= $dano_final;
                $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                </div><br>";
                }else
                {
                    $taxa_bloqueio_personagem = rand(0,$_SESSION['int']); 
                    $dano_final = $atributos_inimigo['str'] - $taxa_bloqueio_personagem;
                    if ($dano_final <0) $dano_final = 0;
                    echo "<br><br><p id='fonte_combate'>Voce recebeu {$dano_final} de dano</p><br>";
                    $sta_batalha_personagem -= $dano_final;
                    $porcentagem_sta_personagem = $sta_batalha_personagem*100/$sta_personagem;
                    if ($porcentagem_sta_personagem<0) $porcentagem_sta_personagem = 0;
                    echo "<div class='barra' id='hp'>
                    <div  id='hp_atual' style='width: {$porcentagem_sta_personagem}%' > {$sta_batalha_personagem}/{$sta_personagem} </div>
                    </div><br>";
                }
            if($taxa_crit_personagem<=$dex_personagem&&$sta_batalha_personagem>0){
                $taxa_bloqueio_inimigo = rand(0,$atributos_inimigo['int']); 
                $dano_final = $crit_personagem - $taxa_bloqueio_inimigo;
                if ($dano_final <0) $dano_final = 0;
                echo "<br><br><p id='fonte_combate'>Voce causou {$dano_final} de dano crítico!</p><br>";
                $sta_batalha_inimigo -= $dano_final;
                $porcentagem_sta_inimigo = $sta_batalha_inimigo*100/$sta_inimigo;
                if ($porcentagem_sta_inimigo<0) $porcentagem_sta_inimigo = 0;
                echo "<div class='barra' id='hp'>
                <div  id='hp_atual' style='width: {$porcentagem_sta_inimigo}%' > {$sta_batalha_inimigo}/{$sta_inimigo} </div>
                </div><br>";
                }elseif($sta_batalha_personagem>0)
                {
                    $taxa_bloqueio_inimigo = rand(0,$atributos_inimigo['int']); 
                    $dano_final = $str_personagem - $taxa_bloqueio_inimigo;
                    if ($dano_final <0) $dano_final = 0;
                    echo "<br><br><p id='fonte_combate'>Voce causou {$dano_final} de dano</p><br>";
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
            $xp_max = $xp_max + 50*$_SESSION['lv'];      
            $sql = "UPDATE `personagens` SET `lv` = {$lv}, `xp_max` = {$xp_max}, `xp` = {$xp}  WHERE id_personagem = '{$id_player}'";
            mysqli_query($conexao,$sql);
            $sql = "SELECT `lv`, `xp`, `xp_max`, `sta` , `str`, `int` ,`dex`  
            FROM rpg.personagens p
            JOIN rpg.atributos a ON a.id_classe = p.id_classe
            WHERE p.id_personagem = '{$id_player}'";
            $level_up = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
            $_SESSION['lv'] = $level_up['lv'];
            $_SESSION['xp'] = $level_up['xp'];
            $_SESSION['xp_max'] = $level_up['xp_max'];
            $_SESSION['sta'] += $level_up['sta'];
            $_SESSION['str'] += $level_up['str'];
            $_SESSION['int'] += $level_up['int'];
            $_SESSION['dex'] += $level_up['dex'];
            $_SESSION['crit'] = $_SESSION['str']+$_SESSION['dex']*2;
            echo "<br><br><p id='fonte_combate'>Parabens, Voce subiu de nivel</p>";
        }
        else{
            $sql = "UPDATE `personagens` SET `xp` = {$xp} WHERE id_personagem = '{$id_player}'";
            mysqli_query($conexao,$sql);
            $sql = "SELECT `xp` FROM `personagens` WHERE id_personagem = '{$id_player}'";
            $xp = mysqli_fetch_array(mysqli_query($conexao,$sql));
            $_SESSION['xp'] = $xp['0'];
            echo "<br><br><p id='fonte_combate'>Voce derrotou seu inimigo e ganhou ". $xp_inimigo. " de experiencia</p>";
        }            
    }
    else {
        echo "<br><br><p id='fonte_combate'>Voce foi derrotado!</p>";
    }

}
?>
 </div>