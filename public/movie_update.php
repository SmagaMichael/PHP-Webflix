<?php
/**
 * Formulaire d'ajout de film
 * 
 * Ici, on va créer un formulaire permettant d'ajouter un film.
 * Le champ title devra faire 2 caractères minimum.
 * Le champ description devra faire 15 caractères minimum.
 * On pourra uploader une jaquette. Le nom du fichier uploadé doit être le nom du film "transformé", "Le Parrain" -> "le-parrain.jpg"
 * Le champ durée devra être un nombre entre 1 et 999.
 * Le champ released_at devra être une date valide.
 * Le champ category devra être un select généré dynamiquement avec les catégories de la BDD
 * On doit afficher les messages d'erreurs et s'il n'y a pas d'erreurs on ajoute le film et on redirige sur la page movie_list.php
 * BONUS : Il faudrait afficher un message de succès après la redirection. Il faudra utiliser soit la session, soit un paramètre dans l'URL
 */
require '../partials/header.php';
//|3 * Sur cette page, on va récupérer l'id dans l'url


if(!isAdmin()){
    display404();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    //|4 * on doit vérifier si l'id est présent ou non (404)
    display404();
}


$movie = getMovie($id);

if(!$movie){
    display404();
}


$title = $movie['title'];


$description = $movie['description'];

$cover = $movie['cover'];

$duration = $movie['duration'];

$released_at = $movie['released_at'];

$categorySelected = $movie['category_id'];

if(!empty($_POST)){
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $cover = $_FILES['cover'];
    $duration = $_POST['duration'];
    $released_at = $_POST['released_at'];
    $categorySelected = $_POST['category'];
    $errors = [];

    if(strlen($title) < 2){
        $errors['title'] = 'Le titre est trop court';
    }

    if(strlen($description) < 15){
        $errors['description'] = 'La description est trop courte';
    }

    if($duration < 1 || $duration > 999){
        $errors['duration'] = 'La durée n\'est pas valide';
    }


    //vérification de la date 
    $released_at = empty($released_at) ? '0000-00-00' : $released_at;

    //2020(-12-08)

    $date = explode('-', $released_at);
    if(!checkdate($date[1], $date[2], $date[0])){
        $errors['released_at'] = 'La date n\'est pas valide';
    }

    //Ici on peut faire l'upload de l'image
    $maxSize = 10 * 1024 *1024;
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    if($cover['error'] === 0 && $cover['size'] < $maxSize &&  in_array($cover['type'], $allowedTypes)){
        // On s'assure que le dossier existe...
        if (!is_dir('assets/uploads')){
            mkdir('assets/uploads');
        }
        
        //On doit générer le nom de l'image 
        //Le super film => le-super-film.ext
        $extension = pathinfo($cover['name'])['extension'];
        $fileName = str_replace(' ', '-',strtolower($title)).'.'.$extension;

        //On doit déplacer le fichier temporaire dans le dossier
        move_uploaded_file($cover['tmp_name'],'assets/uploads/'.$fileName);

    }else if ($cover['error'] === 4 ){//Dans le cas ou on upload pas une nouvelle jaquette
        $fileName = $movie['cover'];//Le film name est toujours celui qui est dans la base 
    }
    //on fait la requete s'il n'y a pas d'erreur 
    else{
        $errors['cover'] = 'Le fichier est trop lourd ou le format est incorrect...';
    }



    //On fait la requete s'il n'y a pas d'erreur
    if(empty($errors)){
        $query = $db->prepare('UPDATE `movie` SET 
        title  = :title,
        description  = :description,
        cover = :cover,
        duration =  :duration,
        released_at = :released_at,
        category_id = :category WHERE id = :id'
       
    );  

    $query->bindValue(':title', $title);
    $query->bindValue(':description', $description);
    $query->bindValue(':cover', $fileName);
    $query->bindValue(':duration', $duration, PDO::PARAM_INT);
    $query->bindValue(':released_at', $released_at);
    $query->bindValue(':category', $categorySelected, PDO::PARAM_INT);
    $query->bindValue(':id', $movie['id'], PDO::PARAM_INT);
    $query->execute();


    header('Location: movie_single.php?id='.$movie['id'].'&status=update');

    }else{?>
        <div class="container alert alert-danger">
            <?php foreach($errors as $error){ ?>
                <p class="text-danger m-0"> <?= $error ?></p>
            <?php } ?>
        </div>


  <?php 

    }
}

 ?>

<div class="container ">
    <h1 class="text-center">Modifier le film</h1>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <form method="POST" enctype="multipart/form-data">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= $title; ?>"><br>

                <label for="description">description</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control" ><?= $description; ?></textarea><br>

                <label for="cover">Jaquette</label>
                <input type="file" name="cover" id="cover" class="form-control" ><br>

                <label for="duration">Durée</label>
                <input type="text" name="duration" id="duration" class="form-control" value="<?= $duration; ?>" ><br>

                <label for="released_at">Sortie</label>
                <input type="date" name="released_at" id="released_at" class="form-control" value="<?= $released_at; ?>"><br>

                <label for="category">Catégorie</label>
                <select name="category" id="category" class="form-control">
                <?php foreach (getCategories() as $category) { ?>
                    <option <?php if($category['id'] === $categorySelected){echo 'selected';} ?>
                    
                    value="<?= $category['id']?>"> 
                    <?= $category['name'];?> 
                </option>
                <?php } ?>
                
                </select>
                <br>
                <button class="btn btn-danger form-control">Modifier</button>
                <?php 
                
                ?>
            </form>
        </div>
    </div>
</div>
<br>


<?php require '../partials/footer.php'; ?>