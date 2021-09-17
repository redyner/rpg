<?php
        include "conexao.php";
        $porcentagem_xp = $_SESSION['xp']*100/$_SESSION['xp_max'];
        if ($porcentagem_xp<0) $porcentagem_xp = 0;

    ?>
    
    <div id="painel_principal">
    <div id="logo"></div>
        <nav>
            <ul>
                <li><a href="http://localhost/rpg"> Pagina Inicial</a></li>      
                <li><a href="http://localhost/rpg/index.php?pagina=dungeon">Dungeons</a></li>
                <li><a href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
                <li id="gold" style="float: right;">GOLD - <?php echo $_SESSION['gold']?></li>
            </ul>
        </nav>

        <div id="painel_personagem">
        
        <a href="" ><div class="avatar_npc" id = "mercador"></div></a>
        <div id="atributos_personagem">
            <br>
            <p id="atributo_xp">EXP</p>
            <div class="barra" id="barra_xp">
                <div id="xp_atual" style="width: <?php echo "<script>porcentagem_xp</script>" ?>%"> <script>document.write(localStorage.getItem('xp'))</script>/<script>document.write(localStorage.getItem('xp_max'))</script></div>
            </div>
            <br><br><br>
            <p id="lista_atributos">NICK - <?php echo $_SESSION['nick'] ?></p>
            <br>
            <p id="lista_atributos">LEVEL - <script>document.write(localStorage.getItem('lv'))</script></p>
            <br>
            <p id="lista_atributos">STA - <script>document.write(localStorage.getItem('sta_personagem'))</script></p>
            <br>
            <p id="lista_atributos">STR - <script>document.write(localStorage.getItem('str_personagem'))</script></p>
            <br>
            <p id="lista_atributos">INT - <script>document.write(localStorage.getItem('int_personagem'))</script></p>
            <br>
            <p id="lista_atributos">DEX - <script>document.write(localStorage.getItem('dex_personagem'))</script></p>

        </div>

        </div>
        <div id="selecao_item">

        <script>
        for (var i = 1; i <= 18 ; i++)
        document.write("<div id = 'slot"+i+"' class='slot' ></div>")
        </script>
        </div>
         </div>