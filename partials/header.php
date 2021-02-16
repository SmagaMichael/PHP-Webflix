<?php  // On inclustout les fichiers de configuration du site
require '../config/database.php'; 
require '../config/config.php';
require '../config/function.php';?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../extension(framework)/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Webflix</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="movie_list.php">Nos films</a>
                </li>

                <?php //commentaire
                    //On doit écrire ici une requete qui récupère les catégories
                    //Ensuite, on va parcourir le tableau de catégorie et remplir le dropdown 
                    // avec ces catégorie
                    //3. BONUS: Ranger le code PHP dans une fonction getCategories();
                    //        Idéalement, on mets la fonction dans le fichier functions.php (à inclure)
                    //        $categories = getCategories();
                ?>



                <li class="nav-item dropdown pl-3">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                    data-toggle="dropdown">Nos catégories</a>
                    <div class="dropdown-menu" >
                    <!-- Pour chaque  élément de catégories qu'on appelera Category on crée un lien -->
                        <?php foreach (getCategories() as $category) { ?>
                            <a class="dropdown-item" href="category_single.php?id=<?= $category['id']; ?>"> 
                                <?= $category['name']?> </a>
                        <?php } ?>
                    </div>
                </li>
            </ul>

            <form class="form-inline my-2 my-lg-0" action="movie_search.php">
                <input class="form-control mr-sm-2" type="search" name="q" placeholder="Search" >
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Go</button>
            </form>
            
         


            <ul class="navbar-nav ml-4">
                    <?php // Si on est connecté, on affiche un menu différent
                    if (isset($_SESSION['user'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                <img src="https://unavatar.now.sh/<?= $_SESSION['user']['email']; ?>" width="40" alt=""
                                     class="rounded-circle mr-2"
                                >
                                <?= $_SESSION['user']['username']; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if(isAdmin()){?>
                                    <a class="dropdown-item" href="add_movie.php">Ajouter un film</a>
                                <?php }?>
                                <a class="dropdown-item" href="#">Mon compte</a>
                                <a class="dropdown-item" href="logout.php">Déconnexion</a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="login.php" class="btn btn-danger">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a href="register.php" class="nav-link">Inscription</a>
                        </li>
                    <?php } ?>
                </ul>
        </div>
    </div>
</nav> <!--FIN DE BARRE NAV -->




<br>

