<?php
session_start();
session_unset($_SESSION['id_player']);
session_destroy();
header("location: http://localhost/rpg");

?>