
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
            $id_player = mysqli_fetch_array(mysqli_query($conexao,$sql));
            if($valida_login == 1)
            {
                $_SESSION['usuario'] = $id_player['0'];
                $id_player = $_SESSION['usuario'];
                $sql = "SELECT nick, lv, xp, xp_max, sta, atk, def, spd, classe FROM rpg.personagens WHERE idpersonagem = '{$id_player}'";
                $info_player = mysqli_fetch_array(mysqli_query($conexao,$sql));
                $_SESSION['nick'] = $info_player['0'];
                $_SESSION['lv'] = $info_player['1'];
                $_SESSION['xp'] = $info_player['2'];
                $_SESSION['xp_max'] = $info_player['3'];
                $_SESSION['sta'] = $info_player['4'];
                $_SESSION['atk'] = $info_player['5'];
                $_SESSION['def']  = $info_player['6'];
                $_SESSION['spd']  = $info_player['7'];
                $_SESSION['classe']  = $info_player['8'];
                $_SESSION['crit'] = $_SESSION['atk']*2;

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