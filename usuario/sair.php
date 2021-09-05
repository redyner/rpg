<?php
session_start();
session_unset($_SESSION['usuario']);
session_destroy();
header("location: http://localhost/RPG");

?>