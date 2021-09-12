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
    <script>document.write("<div id='teste'></div>") </script>
    <a href="http://localhost/rpg"><div id="sair"> Sair</div>  </a>  
    </div>
    

</body>
</html>