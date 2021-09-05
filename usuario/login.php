
<div id="painel_principal">
<div id="logo"></div>
<nav>
    <ul>
        <li><a href = "http://localhost/rpgbrowser"> Página Inicial</a></li>
        <li><a href = "http://localhost/rpgbrowser/index.php?pagina=cadastrar">Cadastrar</a></li>
    </ul>
</nav>

<?php
        include "conexao.php";
        if(isset($_POST['logar']))
        {
            $login = $_POST['login'];
            $senha = $_POST['senha'];

           if(empty($login)||empty($senha)) echo "Todos os campos devem ser preenchidos!";
           else{
            $senha = md5($senha);
            $sql = "SELECT idplayer FROM player WHERE login = '{$login}' AND senha = '{$senha}'";
            $valida_login = mysqli_num_rows(mysqli_query($conexao,$sql));
            if($valida_login == 1)
            {
                $_SESSION['usuario'] = $login;
                $teste_de_sessao = $_SESSION['usuario'];
                header("location: http://localhost/rpgbrowser/index.php?pagina=jogo");
            }else echo "Login ou senha incorretos!";
           }
        }
        ?>

        <!-- formulário de login-->
        <form action="" method="POST" id="painel_login">
            <label for="login">Login</label>
            <input type="text" name='login' id="login">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">
            <input type="submit" value="Login" id="sub_login" name="logar">
        </form>
        
    </div>