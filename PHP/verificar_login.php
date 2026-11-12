<?php
session_start();

if (!isset($_SESSION['utilizador'])) {   # esse isset server para ver se a variavel existe e o ! nega
    header("Location: ../FRONTEND/login.php");
    exit();
}
?>