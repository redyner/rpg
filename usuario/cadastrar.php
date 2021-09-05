    
    <div id="painel_principal">
    <div id="logo"></div>
<nav>
    <ul>
        <li><a href = "http://localhost/rpgbrowser"> Página Inicial</a></li>
    </ul>
</nav>
        
        <?php
        include "conexao.php";
        if(isset($_POST['cadastrar']))
        {
            $login = $_POST['login'];
            $senha = $_POST['senha'];

           if(empty($login)||empty($senha)) echo "Todos os campos devem ser preenchidos!";
           else{
            $senha = md5($senha);
            $sql = "SELECT idplayer FROM player WHERE login = '{$login}'";
            $valida_login = mysqli_num_rows(mysqli_query($conexao,$sql));
            if($valida_login == 0)
            {
                $sql = "INSERT INTO `player`(`login`,`senha`) VALUES ( '$login', '$senha')";
                $teste = mysqli_query($conexao,$sql);
                echo "Cadastro realizado com sucesso!";
            }else echo "Login já cadastrado!";
           }
        }
        ?>

        <!-- formulário de login-->
        <form action="" method="POST" id="painel_login">
            <label for="login">Login</label>
            <input type="text" name='login' id="login">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">
            <input type="submit" value="Cadastrar" id="sub_cadastrar" name="cadastrar">
        </form>

    </div>