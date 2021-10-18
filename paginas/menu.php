<?php if (isset($_SESSION['id_player']) && isset($_SESSION['id_personagem'])) { ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-xl">
            <div class="collapse navbar-collapse" id="navbarsExample07XL">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/rpg"">INICIO</a>            
          </li>
          <li class=" nav-item">
                            <a class="nav-link active" aria-current="page" href="http://localhost/rpg/index.php?pagina=dungeon">DUNGEON</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/rpg/index.php?pagina=market">MARKET</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/rpg/index.php?pagina=forja">FORJA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/rpg/index.php?pagina=arena">ARENA</a>
                    </li>
                    <li class="nav-item dropdown" id="dropdown-login">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown07XL" data-bs-toggle="dropdown" aria-expanded="false"><?php echo  $_SESSION['login'] ?></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown07XL" id="menu_dropdown">
                            <li><a class="dropdown-item" href="http://localhost/rpg/index.php?pagina=perfil">Perfil</a></li>
                            <li><a class="dropdown-item" href="http://localhost/rpg/index.php?pagina=sair">Sair</a></li>
                        </ul>
                    </li>
                </ul>
                <div id="info_moedas">
                    <li class="gold">GOLD <?php echo $_SESSION['gold'] ?></li>
                </div>
            </div>
        </div>
    </nav>
<?php } elseif (isset($_SESSION['id_player']) && !isset($_SESSION['id_personagem'])) { ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-xl">
            <div class="collapse navbar-collapse" id="navbarsExample07XL">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/rpg/index.php?pagina=sair">SAIR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<?php } else { ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-xl">
            <div class="collapse navbar-collapse" id="navbarsExample07XL">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/rpg/index.php?pagina=cadastrar">CADASTRAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/rpg/">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>