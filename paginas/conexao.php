
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname   = "rpg";

// Create connection
$conexao = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conexao) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "";
?>