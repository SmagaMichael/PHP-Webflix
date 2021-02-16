<?php

/*
|-----------------------------------------
|1 * Cette page sera comme movie_list.php sauf que : 
|2 * On doit récupérer l'id de la catégorie dans l'url 
|3 * faire la requete pour récupérer les films de cette catégorie
|4 * ne pas afficher les filtres
*/

require '../partials/header.php';
?>

<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    display404();
}

//on récupére la catégorie en question 
$movies = getMoviesByCategory($id);
$category = getCategory($id);


if(!$category){
    display404();
}
?>



<div class="container">
    <h1><?= $category['name'];?></h1>
    <div class="MainAlea container">
        <?php foreach($movies as $movie){
              require '../partials/card-movie.php';
        }?>
    </div>
</div>


<?php require '../partials/footer.php'; ?>
