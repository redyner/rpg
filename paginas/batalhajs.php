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
        <div id="div_de_barras">
            <div  id='barra_hp_1'>
                <div  id='hp_atual_1'></div>
            </div>
            <div  id='barra_hp_2'>
                <div  id='hp_atual_2'></div>
            </div>
        </div>

        <a href="" ><div class="avatar_personagem_batalha" id = "<?php echo $classe ?>">
 
    </div></a>

        <a href="?pagina=batalha&id=1" ><span class="avatar_inimigo_batalha" id="<?php echo $nick_inimigo?>"></span></a>
        

        </div>
        <button id="atacar"> Atacar </button>


<?php

    $id = $_GET['id'];
    $sql = "SELECT sta, `str`, `int`, dex FROM rpg.atributos a JOIN rpg.inimigos i ON i.id_inimigo = a.id_inimigo WHERE i.id_inimigo = '{$id}'";
    $atributos_inimigo = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
    $sta_inimigo = $atributos_inimigo['sta'];
    $str_inimigo = $atributos_inimigo['str'];
    $int_inimigo  = $atributos_inimigo['int'];
    $dex_inimigo  = $atributos_inimigo['dex'];
    $crit_inimigo = $atributos_inimigo['str']+$atributos_inimigo['dex']*2;
?>

<script>

var sta_inimigo = <?php echo $atributos_inimigo['sta'] ?>;
var sta_batalha_inimigo = sta_inimigo
var sta_batalha_personagem = <?php echo $_SESSION['sta'] ?>;


document.getElementById("atacar").addEventListener("click",setInterval(function(event){
    var sta = <?php echo $_SESSION['sta'] ?>;
    var str = <?php echo $_SESSION['str'] ?>;
    var int = <?php echo $_SESSION['int'] ?>;
    var dex = <?php echo $_SESSION['dex'] ?>;
    var hp_1 = document.getElementById('hp_atual_1');
    var hp_2 = document.getElementById("hp_atual_2");
    var teste = Math.floor(Math.random()*100+1);
    combate(sta,str,int,dex,hp_1,hp_2,teste)
},3000))

function combate(sta,str,int,dex,hp_1,hp_2,teste){
 
    sta_batalha_inimigo -= str
    var porcentagem_sta_inimigo = sta_batalha_inimigo*100/sta_inimigo;
    var porcentagem_sta_personagem = sta_batalha_personagem*100/sta;
    if (porcentagem_sta_inimigo<0) porcentagem_sta_inimigo = 0;
    hp_1.style.width = porcentagem_sta_personagem+"%";
    hp_2.style.width = porcentagem_sta_inimigo+"%";
    if (porcentagem_sta_inimigo==0) clearInterval(combate)


}

</script>