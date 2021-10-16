<?php
include 'functions.php';

$id_player = $_SESSION['id_player'];
$classe = $_SESSION['classe'];
$lv = $_SESSION['lv'];
$xp = $_SESSION['xp'];
$xp_max = $_SESSION['xp_max'];
$sta_personagem = $_SESSION['sta'];
$str_personagem = $_SESSION['str'];
$int_personagem  = $_SESSION['int'];
$dex_personagem  = $_SESSION['dex'];
$porcentagem_xp = $xp * 100 / $xp_max;
if ($porcentagem_xp < 0) $porcentagem_xp = 0;

$id = $_GET['id'];
$sql = "SELECT nm_inimigo FROM inimigos WHERE id_inimigo = '{$id}'";
$nick_inimigo = mysqli_fetch_assoc(mysqli_query($conexao, $sql));
$nick_inimigo = $nick_inimigo['nm_inimigo'];

?>


<div class="conteudo">
    <div class="logo"></div>
    <?php include "menu.php" ?>

    <div class="painel">
        <div class="barras_hp">
            <div class="barra_hp">
                <div class="hp_atual" id='hp_atual_1'></div>
            </div>
            <div id="barra_hp_2" class="barra_hp">
                <div class="hp_atual" id='hp_atual_2'></div>
            </div>
        </div>
        <div class="avatar_batalha" name="<?php echo $classe ?>"></div>
        <div class="avatar_batalha_inimigo" id="<?php echo $nick_inimigo ?>"></div>
        <button class="botao" id="atacar">Atacar</button>
    </div>

    <div id="div_batalha">
        <p id="relatorio"></p>
    </div>


    <?php

    $id = $_GET['id'];
    $sql = "SELECT `sta`, `str`, `int`, `dex`, `xp`, `lv` FROM rpg.atributos a JOIN rpg.inimigos i ON i.id_inimigo = a.id_inimigo WHERE i.id_inimigo = '{$id}'";
    $atributos_inimigo = mysqli_fetch_assoc(mysqli_query($conexao, $sql));
    ?>

    <script>
        var sta_inimigo = <?php echo $atributos_inimigo['sta'] ?>;
        var hp_inimigo = sta_inimigo * 10;
        var hp_batalha_inimigo = hp_inimigo;
        var str_inimigo = <?php echo $atributos_inimigo['str'] ?>;
        var int_inimigo = <?php echo $atributos_inimigo['int'] ?>;
        var dex_inimigo = <?php echo $atributos_inimigo['dex'] ?>;
        var xp_inimigo = <?php echo $atributos_inimigo['xp'] ?>;
        var lv_inimigo = <?php echo $atributos_inimigo['lv'] ?>;


        var lv = <?php echo $_SESSION['lv'] ?>;
        var xp = <?php echo $_SESSION['xp'] ?>;
        var xp_max = <?php echo $_SESSION['xp_max'] ?>;
        var gold = <?php echo $_SESSION['gold'] ?>;

        var sta_personagem = <?php echo $_SESSION['sta'] ?>;
        var hp_personagem = sta_personagem * 10;
        var hp_batalha_personagem = hp_personagem;
        var str_personagem = <?php echo $_SESSION['str'] ?>;
        var int_personagem = <?php echo $_SESSION['int'] ?>;
        var dex_personagem = <?php echo $_SESSION['dex'] ?>;

        var sta_lv = <?php echo $_SESSION['sta_lv'] ?>;
        var str_lv = <?php echo $_SESSION['str_lv'] ?>;
        var int_lv = <?php echo $_SESSION['int_lv'] ?>;
        var dex_lv = <?php echo $_SESSION['dex_lv'] ?>;
    </script>
</div>