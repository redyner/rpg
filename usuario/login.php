
<div id="painel_principal">
<div id="logo"></div>
<nav>
    <ul>
        <li><a href = "http://localhost/rpg"> Página Inicial</a></li>
        <li><a href = "http://localhost/rpg/index.php?pagina=cadastrar">Cadastrar</a></li>
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
            $sql = "SELECT id_player FROM player WHERE login = '{$login}' AND senha = '{$senha}'";
            $valida_login = mysqli_num_rows(mysqli_query($conexao,$sql));
            $id_player = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
            if($valida_login == 1)
            {
                $_SESSION['usuario'] = $id_player['id_player'];
                $id_player = $_SESSION['usuario'];
                $sql = "SELECT nick, lv, xp, xp_max, c.nome, sta, atk, def, spd 
                FROM rpg.personagens p 
                JOIN rpg.classes c ON c.id_classe = p.id_classe
                JOIN rpg.atributos a ON c.id_classe = a.id_classe 
                WHERE p.id_personagem = '{$id_player}'";
                $info_player = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

//lista equipamentos
                // $sql = "SELECT sta,atk,def,spd,refino
                // FROM rpg.iventarios i
                // JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
                // JOIN rpg.atributos a ON i.id_item = a.id_item
                // WHERE i.id_personagem = '{$id_player}' AND slot IS NULL";
                // $equipamento = mysqli_query($conexao,$sql);
                // $i=1;
                // $equipamentos['slot1'] = '';
                // while($i<=($equipamento->num_rows)){
                // $equipamentos["slot".$i] = mysqli_fetch_assoc($equipamento);
                // $i = $i+1;
                // }
                // $item_slot1 = $equipamentos['slot1']['sta'];

                $sql = "SELECT sum(sta*(refino+1)) sta, sum(atk*(refino+1)) atk, sum(def*(refino+1)) def, sum(spd*(refino+1)) spd, refino
                FROM rpg.iventarios i
                JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
                JOIN rpg.atributos a ON i.id_item = a.id_item
                WHERE i.id_personagem = '{$id_player}' AND slot IS NULL";
                $equipamento = mysqli_fetch_assoc(mysqli_query($conexao,$sql));


                $_SESSION['sta_itens_equipados']=$equipamento['sta'];
                $_SESSION['atk_itens_equipados']=$equipamento['atk'];
                $_SESSION['def_itens_equipados']=$equipamento['def'];
                $_SESSION['spd_itens_equipados']=$equipamento['spd'];
                $_SESSION['nick'] = $info_player['nick'];
                $_SESSION['lv'] = $info_player['lv'];
                $_SESSION['xp'] = $info_player['xp'];
                $_SESSION['xp_max'] = $info_player['xp_max'];
                $_SESSION['classe']  = $info_player['nome'];
                $_SESSION['sta'] = (($info_player['sta']*10)+($info_player['lv']*$info_player['sta']))+$equipamento['sta'];
                $_SESSION['atk'] = ($info_player['atk']+($info_player['lv']*$info_player['atk']))+$equipamento['sta'];
                $_SESSION['def']  = ($info_player['def']+($info_player['lv']*$info_player['def']))+$equipamento['sta'];
                $_SESSION['spd']  = ($info_player['spd']+($info_player['lv']*$info_player['spd']))+$equipamento['sta'];
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