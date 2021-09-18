<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste</title>
    <link rel = "stylesheet" href = "style.css">

    <script>
        function cor(div,cor){
            div.style.backgroundColor = cor;
        }

        function alerta(){
            alert("teste")
        }

        function add_eventos(){

        var teste = document.getElementById("teste")

        teste.addEventListener("click",alerta)

        teste.addEventListener("mouseover",function(event){
            cor(teste,'red')
        })

        teste.addEventListener("mouseout",function(event){
            cor(teste,'white')
        })

        }

        window.addEventListener("load",add_eventos)
    </script>

</head>
<body>

    <div id="container">
    <div id='teste'></div>
    <a href="http://localhost/rpg"><div id="sair"> Sair</div>  </a>  
    </div>
    
    <form id="formulario_levelup">
XP
<input type="number" name="set_xp" id="set_xp">
STA
<input type="number" name="set_sta" id="set_sta">
STR
<input type="number" name="set_str" id="set_str">
INT
<input type="number" name="set_int" id="set_int">
DEX
<input type="number" name="set_dex" id="set_dex">
<button id="trocar" name="trocar">Trocar</button>
</form>

    <script src = "../js/jquery.js"></script>
    <script src = "../js/ajax.js"></script>

</body>
</html>