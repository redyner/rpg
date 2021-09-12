<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste</title>
    <link rel = "stylesheet" href = "style.css">
</head>
<body>

    <div id="teste" onmouseover="mudacor(this,'red')" onmouseout="mudacor(this,'black')" onclick="alerta()"></div>
    <a href="http://localhost/rpg"> Sair</a>
    <script>
        function mudacor(div,cor){
            div.style.backgroundColor = cor;
        }

        function alerta(){
            alert("teste")
        }

    </script>
</body>
</html>