<?php
include 'functions.php';
$porcentagem_xp = $_SESSION['xp'] * 100 / $_SESSION['xp_max'];
if ($porcentagem_xp < 0) $porcentagem_xp = 0;
?>

<div class="conteudo" id="conteudo_perfil">
    <div class="logo"></div>
    <?php include "menu.php" ?>
    <div class="avatar" id="avatar_perfil" name="<?php echo $_SESSION['classe'] ?>"></div>
    <div class="painel_infor" id="painel_perfil">
        <p class="titulo">Painel do Jogador</p>
        <p>Login: <?php echo $_SESSION['login'] ?> </p>
        <p>Nick: <?php echo $_SESSION['nick'] ?> </p>
        <p>Level: <?php echo $_SESSION['lv'] ?> </p>
        <div id="opcoes_perfil">
            <button id="botao_alterar" class="botao" onclick="alterar_senha()">Alterar Senha</button>
        </div>
        <div id="alterar_senha" class="form">
            <form action="http://localhost/rpg/paginas/sql.php" method="POST" id="painel_login">
                <label for="login">Senha Atual</label>
                <input class="input" required type="password" name="senha_atual" id="senha">
                <label for="senha">Nova Senha</label>
                <input class="input" required type="password" name="nova_senha" id="senha">
                <label for="senha">Confirme a Senha</label>
                <input class="input" required type="password" name="confirmacao_senha" id="senha">
                <input class="input" required type="hidden" name="opcao" value="alterar_senha">
                <input class="botao" type="submit" value="Alterar" id="botao_alterar">
            </form>
        </div>
    </div>


    <script src="../js/jquery.js"></script>
    <script src="../js/ajax.js"></script>
</div>