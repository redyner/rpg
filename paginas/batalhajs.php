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

        <div class="avatar_personagem_batalha" id = "<?php echo $classe ?>"></div>
        <div class="avatar_inimigo_batalha" id="<?php echo $nick_inimigo?>"></div>
        
        <button id="atacar"> Atacar </button>
        </div>
        
        <div id="div_batalha"><p id="relatorio"></p></div>


<?php

    $id = $_GET['id'];
    $sql = "SELECT `sta`, `str`, `int`, `dex`, `xp` FROM rpg.atributos a JOIN rpg.inimigos i ON i.id_inimigo = a.id_inimigo WHERE i.id_inimigo = '{$id}'";
    $atributos_inimigo = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
?>

    <script>
        var sta_inimigo = <?php echo $atributos_inimigo['sta'] ?>;
        var hp_inimigo = sta_inimigo*10;
        var hp_batalha_inimigo = hp_inimigo;
        var str_inimigo = <?php echo $atributos_inimigo['str'] ?>;
        var int_inimigo = <?php echo $atributos_inimigo['int'] ?>;
        var dex_inimigo = <?php echo $atributos_inimigo['dex'] ?>;
        var xp_inimigo = <?php echo $atributos_inimigo['xp'] ?>;

    </script>

    <script>
        localStorage.setItem('nick','<?php echo $_SESSION['nick'] ?>');
        localStorage.setItem('lv',<?php echo $_SESSION['lv'] ?>);
        var lv = parseInt(localStorage.getItem('lv'));
        localStorage.setItem('xp',<?php echo $_SESSION['xp'] ?>);
        var xp = parseInt(localStorage.getItem('xp'));
        localStorage.setItem('xp_max',<?php echo $_SESSION['xp_max'] ?>);
        var xp_max = parseInt(localStorage.getItem('xp_max'));
        localStorage.setItem('classe','<?php echo $_SESSION['classe'] ?>');
        localStorage.setItem('sta_personagem',<?php echo $_SESSION['sta'] ?>);
        var sta_personagem = parseInt(localStorage.getItem('sta_personagem'));
        var hp_personagem = sta_personagem*3;
        var hp_batalha_personagem = hp_personagem;
        localStorage.setItem('str_personagem',<?php echo $_SESSION['str'] ?>);
        var str_personagem = parseInt(localStorage.getItem('str_personagem'));
        localStorage.setItem('int_personagem',<?php echo $_SESSION['int'] ?>);
        var int_personagem = parseInt(localStorage.getItem('int_personagem'));
        localStorage.setItem('dex_personagem',<?php echo $_SESSION['dex'] ?>); 
        var dex_personagem = parseInt(localStorage.getItem('dex_personagem'));
        localStorage.setItem('gold',<?php echo $_SESSION['gold'] ?>);
        var gold = parseInt(localStorage.getItem('gold'));   
    </script>