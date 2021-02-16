<?php

/* 
|-----------------------------------------------
|Fonctions utiles pour le site
|-----------------------------------------------
|Ici on va déclarer toutes les fonctions que seront utilisables partout sur le site
|-----------------------------------------------*/


/*Permet de récupérer toutes les catégories dans la BDD (base de données)*/
function getCategories(){
    global $db; //On utilise la variable $db(PDO)
    //global sert a trouver la variable n'importe dans l'index.php du moment qu'elle est déclaré 
    $query = $db->query('SELECT * FROM `category` ORDER BY `name`');
    return $query->fetchAll();
}


/*Permet de récupérer 4film de façon aléatoire*/
function getMovies4Alea(){
    global $db; 
    $query = $db->query('SELECT * FROM `movie` ORDER BY RAND() LIMIT 4');
    return $query->fetchAll();
}


/*Permet de récupérer 3film de façon aléatoire*/
function getMovies3Alea(){
    global $db; 
    $carouselMovies = $db->query('SELECT * FROM `movie` WHERE `cover` IS NOT NULL ORDER BY RAND() LIMIT 3');
    return $carouselMovies->fetchAll();
}


// WHERE `cover` IS NOT NULL => si l'image est  null on ne l'affiche pas 
// On récupère ici tout les films  
function getAllMovies(){
    global $db;
    $AllMovies = $db ->query('SELECT * FROM `movie`');
    return $AllMovies-> fetchAll();
}

//
function getMoviesCat($sort){
    global $db;
    if(!in_array($sort, ['id', 'title', 'duration', 'released_at'])){
        $sort = 'id';
    }
    // ASC = ascendant 
    $query = $db->query('SELECT * FROM `movie` ORDER BY '.$sort.' ASC ');
  
    return $query->fetchAll();
}


//Permet de rechercher un film dans la BDD
//La fonction nous renvoie un tableau de film
//LIKE = permet de cherche la valeur de $q dans le contenu des titre des film
function searchMovie($q){
    global $db;

    $orderBy = $_GET['sort'] ?? 'id'; //Si $_GET['sort'] existe on prend sa valeur
    //$q = '%"; DROP table payment
    if (!in_array($orderBy, ['id', 'title', 'duration', 'released_at'])) {
        // Si $orderBy vaut autre chose que id, title, duration ou released_at
        // on le force à id
        $orderBy = 'id';
    }

    // $query = $db->query('SELECT * FROM `movie` WHERE `title` LIKE "%'.$q.'%"' );

    $query = $db->prepare('SELECT * FROM `movie` WHERE `title` LIKE :q ORDER BY '.$orderBy);
    $query->bindvalue(':q', '%'.$q.'%');
    //Le bindvalue permet de remplacer les parametres de la requete préparé par la ''vraie'' valeur 
    $query->execute(); //Le execute est necessaire lors d'une requete préparée
    //On peut aller plus vite en marquant 
    //$query->execute([':q', '%'.$q.'%']);
    return $query->fetchAll();
}

//Afficher page 404
function display404(){
    http_response_code(404);//On peut forcer le statut 404 sur la requete
    echo '<div classe="container"> <h1>404</h1> </div>';
    require '../partials/footer.php'; exit();
}


//récuperer les film selon leur categorie
function  getMoviesByCategory($id){
    global $db;
    $query = $db->prepare('SELECT * FROM `movie` WHERE category_id = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchAll();
}



/*Cette fonction permet de récupérer une catégorie seule*/
function getCategory($id) {
    global $db;

    $query = $db->prepare('SELECT * FROM category WHERE id = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    return $query->fetch(); // Fetch renvoie une seule ligne
}


function getMovie($id){
global $db;
$query = $db->prepare('SELECT * FROM `movie` WHERE id = :id');
$query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    return $query->fetch(); // Fetch renvoie une seule ligne
}

function convertToHours($duration){
    $hours = floor($duration / 60);
    $minutes = $duration - 60 * $hours;

    if($minutes < 10){
        $minutes = '0'.$minutes;
    }
    return $hours.'h'.$minutes;
}


function formatDate($date, $format = 'd F Y '){
    $formatedDate = date($format, strtotime($date));
    return $formatedDate;
}


function getCommentsByMovie($id){
    global $db;
    $query = $db->prepare(
        'SELECT * FROM `comment` WHERE movie_id1 = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll();
}

function getAverageMovie($id){
    global $db;
    $query = $db->prepare('SELECT AVG(note)  FROM `comment` WHERE movie_id1 = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    return round($query->fetchColumn(), 2);
}


function isAdmin(){
    $admins = ['admin@admin.fr']; // On défini la liste des admins

     if(isset($_SESSION['user'])){ // Si le user est connecté
        $user = $_SESSION['user'];
     }else{     // sinon on retourne directement false , il n'est pas connecté
         return false;
     }

     if(in_array($user['email'], $admins)){
         return true;   // ok si l'email du user est bien présent dans le tableau administrateurs
     }
     return false; //si aucun des if suivant n'est exécuté, on retoure false
}