<?php

session_start();

include 'functions.php';

$atributos['gold'] = $_SESSION['gold'];

$atributos_json = json_encode($atributos);
echo json_encode($atributos);

?>