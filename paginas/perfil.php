<?php
include 'functions.php';
$porcentagem_xp = $_SESSION['xp'] * 100 / $_SESSION['xp_max'];
if ($porcentagem_xp < 0) $porcentagem_xp = 0;
?>

<div id="painel_principal">
    <div id="logo"></div>
    <nav>
        <ul>
            <li><a href="http://localhost/rpg"> Pagina Inicial</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=dungeon">Dungeons</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=market">Market</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=forja">Forja</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=arena">Arena</a></li>
            <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
            <li><a href="http://localhost/rpg/teste/teste.php">Teste Eventos</a></li>
            <li class="gold" style="float: right;">GOLD - <?php echo $_SESSION['gold'] ?></li>
        </ul>
    </nav>

    <div id="painel_personagem">
        <div class="avatar_personagem_selecao" name="<?php echo $_SESSION['classe'] ?>"></div>
        <div id="painel_perfil">
            <p id="titulo_perfil">Painel do Jogador</p>
            <div id="dados_perfil">
                <label for="">Login</label>
                <input type="text" disabled value="<?php echo $_SESSION['login'] ?>">
                <label for="">NICK</label>
                <input type="text" disabled value="<?php echo $_SESSION['nick'] ?>">
                <label for="">LEVEL</label>
                <input type="text" disabled value="<?php echo $_SESSION['lv'] ?>">                
            </div>

            <div id="opcoes_perfil">
            <button id="botao_alterar" class="botao_alterar1" onclick="alterar_senha()">Alterar Senha</button>                
            </div>

            <div id="alterar_senha">
                <form action="http://localhost/rpg/paginas/sql.php" method="POST" id="painel_login">
                    <label for="login">Senha Atual</label>
                    <input type="password" name="senha_atual" id="senha">
                    <label for="senha">Nova Senha</label>
                    <input type="password" name="nova_senha" id="senha">
                    <label for="senha">Confirme a Senha</label>
                    <input type="password" name="confirmacao_senha" id="senha">
                    <input type="hidden" name="opcao" value="alterar_senha">
                    <input type="submit" value="Alterar" id="botao_alterar">
                </form>
            </div>
        </div>
    </div>
    


    <script src="../js/jquery.js"></script>
    <script src="../js/ajax.js"></script>