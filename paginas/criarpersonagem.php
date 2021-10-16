    <div class="conteudo">
        <div class="logo"></div>
        <nav class="menu">
            <ul>
                <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
            </ul>
        </nav>
        <form action="http://localhost/RPG/paginas/sql.php" method="POST" class="form" id="form_login">
            <label for="login">nick</label>
            <input class="input" type="text" name='nick' id="login" required>
            <label for="classe">classe</label>
            <select class="select" name="classe" required>
                <option></option>
                <option value="1">Warrior</option>
                <option value="2">Archer</option>
                <option value="3">Wizard</option>
            </select>
            <input type="hidden" name="opcao" value="novo_personagem">
            <input class="botao" type="submit" name="criarPersonagem" value="Criar" id="sub_login">
        </form>
    </div>