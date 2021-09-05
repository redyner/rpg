    <div id="painel_principal">
    <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpgbrowser"> Página Inicial</a></li>
                <li><a href="http://localhost/rpgbrowser/index.php?pagina=sair">Sair</a></li>
            </ul>
        </nav>

        <div id="painel_batalha">

        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo" >inimigo 1</span></a>
        <a href="" ><div class="avatar_personagem"></div></a>
            <div class="barra" id="hp">
                <div  id="hp_atual" ></div>
            </div>
            <div class="barra" id="xp">
                <div  id="xp_atual" ></div>
            </div>
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
        $taxa_crit_personagem = rand(1,100);
        $taxa_crit_inimigo = rand(1,100);

        if($spd_personagem>$spd_inimigo)
        {
            if($taxa_crit_personagem<=50){
            echo "você causou {$crit_personagem} de dano crítico!<br>";
            $hp_batalha_inimigo -= $crit_personagem;
            }else
            {
                echo "você causou {$atk_personagem} de dano<br>";
                $hp_batalha_inimigo -= $atk_personagem;
            }
            if($taxa_crit_inimigo<=10&&$hp_batalha_inimigo>0){
            echo "você recebeu {$crit_inimigo} de dano crítico!<br>";
            $hp_batalha_personagem -= $crit_inimigo;
            }elseif($hp_batalha_inimigo>0)
            {
                echo "você recebeu {$atk_inimigo} de dano<br>";
                $hp_batalha_personagem -= $atk_inimigo;
            }
        }else
        {
            if($crit_inimigo<=10&&$hp_batalha_inimigo>0){
                echo "você recebeu {$crit_inimigo} de dano crítico!<br>";
                $hp_batalha_personagem -= $crit_inimigo;
                }else
                {
                    echo "você recebeu {$atk_inimigo} de dano<br>";
                    $hp_batalha_personagem -= $atk_inimigo;
                }
            if($crit_personagem<=50&&$hp_batalha_personagem>0){
                echo "você causou {$crit_personagem} de dano crítico!<br>";
                $hp_batalha_inimigo -= $crit_personagem;
                }elseif($hp_batalha_personagem>0)
                {
                    echo "você causou {$atk_personagem} de dano<br>";
                    $hp_batalha_inimigo -= $atk_personagem;
                }
        }
    }

    if($hp_batalha_personagem>0) echo "Você derrotou seu inimigo!";
    else echo "Você foi derrotado!";

}
?>

    </div>