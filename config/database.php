<?php
/* 
|-----------------------------------------------
|Connexion à la base de données
|-----------------------------------------------
|Permet d'établir la connexion entre php et MySQL
|-----------------------------------------------*/

//On va pouvoir se connecter avec PDO
try{
$db = new PDO('mysql:host=localhost;port=3306;dbname=webflix','root','',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //On active les erreurs SQL
]);

}catch(Exception $exception){
    echo $exception->getMessage();  //Affiche le message de l'erreur quand ça detecte pas la base 
    exit(); // Arrete le script PHP

}
//var_dump($db);
