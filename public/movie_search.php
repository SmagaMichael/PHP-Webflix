<?php

/*
|-----------------------------------------
|1 * Dans ce dossier, on va afficher les films par rapport à la recherche
|2 * On doit récupérer le parametre q (pour query) dans l'URL
|3 * Si le paramètre n'est pas présent, soit on affiche une 404,  soit un message ,soit on redirige ver les films
|4 * Si le parametre est présent, il faut faire la bonne requete SQL (like)
|6 * Et s'il n'y a pas de film ? On affiche "la recher n'a rien donné"
*/

require '../partials/header.php';
?>


<?php
if(isset($_GET['q'])){
    $q = $_GET['q'];

}else{
    echo'<div class="container"><h1> 404 </h1></div>';
    require '../partials/footer.php'; exit();
}
$movies = searchMovie($q);

// 5 * On affiche le résultat (les films) comme sur les autres pages ...
?>


<ul>
    <li class="nav-item dropdown pl-3 btn btn-danger">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
        data-toggle="dropdown">Trier par:</a>
        <div class="dropdown-menu" >
        <!-- Pour chaque  élément de catégories qu'on appelera Category on crée un lien -->
                <a class="dropdown-item" href="movie_search.php?sort=title&q=<?= $q; ?>"> Nom </a>
                <a class="dropdown-item" href="movie_search.php?sort=duration&q=<?= $q; ?>"> Durée </a>
                <a class="dropdown-item" href="movie_search.php?sort=released_at&q=<?= $q; ?>"> Date </a>
        </div>
    </li>
</ul>




<div class="MainAlea container">


    <?php 
    //|6 * Et s'il n'y a pas de film ? On affiche "la recher n'a rien donné"
    if (empty($movies)){?>
        <h1>La recherche n'a rien donné</h1>
    <?php }
    
    foreach ($movies as $movie){
        require '../partials/card-movie.php';
    }?>
</div>







<?php
require '../partials/footer.php';
?>
