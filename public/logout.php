<?php
session_start();

unset($_SESSION['user']); // On deconnecte l'utilisateur

header('location:index.php');