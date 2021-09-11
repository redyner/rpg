    <div id="painel_principal">
        <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpg"> Pagina Inicial</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
            </ul>
        </nav>

        <form action="" method="POST" id="painel_login">
            <label for="login">nick</label>
            <input type="text" name='nick' id="login">
            <label for="classe">classe</label>
            <select name="classe">
                <option value="1">Warrior</option>
                <option value="2">Archer</option>
                <option value="3">Wizard</option>
            </select>
            <input type="submit" name="criarPersonagem" value="Criar" id="sub_login">
        </form>

        <?php
        include 'conexao.php';
        if (isset($_POST['criarPersonagem'])) {

            $nick = $_POST['nick'];
            $classe = $_POST['classe'];
            $id_player = $_SESSION['id_player'];

            if (empty($nick)) echo "Insira um nome!";
            else {
                $sql = "SELECT nick FROM personagens WHERE nick = '{$nick}'";
                $novo_usuario = mysqli_num_rows(mysqli_query($conexao, $sql));
                if (!empty($novo_usuario)) {
                    echo "Este nome já esta sendo utilizado!";
                } else {
                    $sql = "INSERT INTO `personagens`(`nick`, `id_classe`, `id_player`) 
                     VALUES ( '$nick', '$classe', '$id_player' )";
                    $sql = mysqli_query($conexao, $sql);
                    session_unset();
                    session_destroy();                   
                    echo "<script type=\"text/javascript\">
                    alert ('Personagem Criado com Sucesso!');   
                    location.href = 'http://localhost/rpg';                 
                    </script>";
                }
            }
        }
        ?>
    </div>