
<?php
require '../partials/header.php';


if(isset($_GET['sort'])){
    $sort = $_GET['sort'];
}else{
    $sort = 'id';
}

$variableaupif = getMoviesCat($sort);

?>

<!--Bouton TRIER PAR -->
<ul>
    <li class="nav-item dropdown pl-3 btn btn-danger">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
        data-toggle="dropdown">Trier par:</a>
        <div class="dropdown-menu" >
        <!-- Pour chaque  élément de catégories qu'on appelera Category on crée un lien -->
                <a class="dropdown-item" href="movie_list.php?sort=title"> Nom </a>
                <a class="dropdown-item" href="movie_list.php?sort=duration"> Durée </a>
                <a class="dropdown-item" href="movie_list.php?sort=released_at"> Date </a>
        </div>
    </li>
</ul>


<!--  Afficher les fiches de films  -->
<div class="MainAlea container">
    
    <?php foreach ($variableaupif as $movie){require '../partials/card-movie.php';}?>


</div>








<?php
require '../partials/footer.php';
?>
