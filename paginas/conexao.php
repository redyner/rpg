
<?php
$servername = "mysql-51231-0.cloudclusters.net";
$username = "admin";
$password = "T7YEDd60";
$dbname   = "rpg";
$dbServerPort = "19464";

// Create connection
$conexao = new mysqli($servername, $username, $password, $dbname, $dbServerPort,);

// Check connection
if (!$conexao) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>