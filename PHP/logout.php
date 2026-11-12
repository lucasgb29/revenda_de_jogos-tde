
<?php
session_start();

session_unset(); # limpar o bagulho


session_destroy(); # destroi a sess

header("Location: ../FRONTEND/login.html"); # auto expicativo
exit();
?>
