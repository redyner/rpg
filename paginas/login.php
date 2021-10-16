
<div class="conteudo">
    <div class="logo"></div>
    <nav class="menu">
    <ul>
        <li><a href="http://localhost/rpg/index.php?pagina=cadastrar"">Cadastrar</a></li>
    </ul>
</nav>
    <form action="http://localhost/RPG/paginas/sql.php" method="POST" class="form" id="form_login">
        <label class="label" for="login">Login</label>
        <input type="text" name='login' class="input" id="login" required>
        <label class="label" for="senha">Senha</label>
        <input type="password" name="senha" class="input" id="senha" required>
        <input type="hidden" name="opcao" value="login">    
            <input type="submit" value="Login" class="botao" id="botao_login" name="logar">                
    </form>
</div>