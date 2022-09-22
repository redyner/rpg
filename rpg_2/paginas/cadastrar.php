    <div class="conteudo">
        <div class="logo"></div>
        <?php include "menu.php" ?>
        <form action="http://localhost/RPG/paginas/sql.php" method="POST" class="form" id="form_login">
            <label for="login">Login</label>
            <input type="text" name='login' id="login" class="input" required>
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" class="input" required>
            <input type="hidden" name="opcao" value="novo_usuario">
            <input type="submit" value="Cadastrar" name="cadastrar" class="botao">
        </form>
    </div>