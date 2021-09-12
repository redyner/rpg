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
            div[1].style.backgroundColor = cor;
        }

        function alerta(){
            alert("teste")
        }

        function add_eventos(){

        var teste = document.getElementsByID("teste")

        teste[1].addEventListener("click",alerta)

        teste[1].addEventListener("mouseover",function(event){
            cor(teste,'red')
        })

        teste[1].addEventListener("mouseout",function(event){
            cor(teste,'white')
        })

        }

        window.addEventListener("load",add_eventos)
    </script>

</head>
<body>

    <div id="container">
    <div class='teste'></div>
    <div class='teste'></div>
    <div class='teste'></div>
    <a href="http://localhost/rpg"><div id="sair"> Sair</div>  </a>  
    </div>
    

</body>
</html>