
<?php
require '../partials/header.php';
?>


<!--
comment faire des requetes avec le PDO
La méthode query de PDO renvoie un objet PDOstatement, cela ne renvoie pas encore 
le résultat de la requete
Ici, on fait la requete pour récupérer les catégories-->

<?php
 
/* $query = $db->query('SELECT * FROM category');
var_dump($query);

fetchAll renvoie un tableau qui contient toutes les lignes 
de la requete précédente
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

On peut aller plus vide en écrivant cela 
$categories = $db->query('SELECT * FROM category')->fetchAll();

echo '<pre>';
var_dump($categories);
echo '</pre>';

//On va parcourir toutes les catégories 
foreach ($categories as $category){?>

    <div>
        <h1><?= $category['name']; ?></h1>
    </div>
<?php }*/
/*

 * 1. On va poser le carousel des films ci-dessous
 * 2. Par défaut, on utilise Bootstrap et on va afficher 3 jaquettes de films par slide (Voir vidéo)
 * 3. On aura 3 slides donc 9 films ce qui veut dire qu'on doit écrire une requête SQL qui récupère
 *    les 9 derniers films par date de sortie dont le champ cover n'est pas null.
 * 4. Pour la boucle, on part d'un tableau de 9 éléments et on doit l'afficher dans le code HTML ci-dessous
 */

?>

 
 

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>

  <div class="carousel-inner">

    <div class="carousel-item active">
        <div class="test">
            <?php foreach (getMovies3Alea() as $movie) { ?>
                <img src="assets/uploads/<?= $movie['cover']; ?>" class="d-block col-4 w-100" alt="...">
            <?php } ?>
        </div>
    </div>

    <div class="carousel-item">
        <div class="test">
            <?php foreach (getMovies3Alea() as $movie) { ?>
                <img src="assets/uploads/<?= $movie['cover']; ?>" class="d-block col-4 w-100" alt="...">
            <?php } ?>
        </div>
    </div>

    <div class="carousel-item">
        <div class="test">
            <?php foreach (getMovies3Alea() as $movie) { ?>
                <img src="assets/uploads/<?= $movie['cover']; ?>" class="d-block col-4 w-100" alt="...">
            <?php } ?>
        </div>
    </div>
  </div>



  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<?php 
//Si l'utilisateur vient de se connecter 
if(isset($_GET['status']) && $_GET['status'] === 'success'){
    echo '<div class="container alert alert-success"> Vous êtes connectés </div>';
}

?>








<div class="container titleAlea" >
    <h1>Sélection de film aléatoire</h1>
</div>


<div class="MainAlea container">
    <?php foreach (getMovies4Alea() as $movie) { ?>

        <div class="card">
            <img src="assets/uploads/<?= $movie['cover']; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $movie['title']?></h5>
                <p class="card-text">Date de sortie : <?= substr($movie['released_at'],0,4); ?></p>
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item"><?= $movie['description']?></li>
                <li class="list-group-item"><a href="#" 
                class="card-link btn btn-danger btn-block">Voir film</a></li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">★★★☆☆</a>
            </div>
        </div>
    <?php } ?>
</div>



<?php
require '../partials/footer.php';
?>
