<?php
/*
|-----------------------------------------
|1 * Récupérer les information du film
|2 * Sur chaque lien "voir le film", on doit ajouter un lien ver movie_single.php
|3 * Sur cette page, on va récupérer l'id dans l'url
|4 * on doit vérifier si l'id est présent ou non (404)
|5 * On doit récuperer le film dans la base de donnée avec l'id 
|6 * On affiche les information du film  jaquette , titre , durée  date description
|7 * On va aussi afficher le nom de la catégorie du film 
*/
require '../partials/header.php';


?>


<?php
//|3 * Sur cette page, on va récupérer l'id dans l'url
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


if(isset($_GET['status']) && $_GET['status'] === 'success'){
    echo'<div class="alert alert-success"> Le film a bien été ajouté ... </div>';
}else if (isset($_GET['status']) && $_GET['status'] === 'update') {
    echo'<div class="alert alert-success"> Le film a bien été modifié ... </div>';
}

?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <img class="img-fluid" src="assets/uploads/<?= $movie['cover']; ?>" alt="<?= $movie['title'];?>">
        </div>
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h1><?= $movie['title'];?></h1><span class="small-text"><?php $movie[''] ?></span>
                    <p>Durée: <?= convertToHours($movie['duration']); ?></p>
                    <p>Sortie le: <?= formatDate($movie['released_at']); ?></p>

                    <div>
                        <?= $movie['description']; ?>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <?php 
                        //On va récuperer la note moyenne dans la BDD grace au commentaire
                        $averageMovie = getAverageMovie($movie['id']);
                        echo $averageMovie.'/5';

                        for($i = 1; $i <= 5; $i++){
                            echo($i <= $averageMovie) ? '★' : '☆';
                        }

                    ?>
                   
                </div>
            </div>

            <div class="card shadow mt-5">
                <div class="card-body">
                        <div>
                            liste des commentaires
                        </div>
                        <br>    
                        <?php 
                            //Récupérer les commentaires
                            $comments = getCommentsByMovie($movie['id']);

                            foreach($comments as $comment){?>
                                
                                <div class="mb-3">
                                    <p>
                                        <strong><?= $comment['nickname']; ?></strong>
                                        <span><?= formatDate($comment['created_at'],'d/m/Y à H\hi'); ?></span>
                                    </p>
                                    <p>
                                        <?= $comment['message']; ?>
                                        <?= $comment['note']; ?>/5
                                    </p>
                                </div>

                                <?php } ?>

                        







                    <?php
                        //traitement du formulaire
                        if(!empty($_POST)){
                            $nickname = htmlspecialchars($_POST['nickname']) ;
                            $message = strip_tags($_POST['message']) ;
                            $note = $_POST['note'];
                            $errors = [];

                            //On vérifie la validité des champs ...
                            if(empty($nickname)){
                                $errors['nickname'] = 'Le pseudo est vide';
                            }

                            // Le message doit faire 15 caractere minimum
                            if(strlen($message) < 15 ){
                                $errors['message'] = 'Lemessage est trop court';
                            }

                            //La note doit etre entre 0 et 5 
                            if($note < 0 || $note > 5){
                                $errors['note'] = 'La note n\'est pas correcte';
                            }
                           
                            //On fait la requete s'il n'y a pas d'erreurs
                            if(empty($errors)){
                                //requete SDL ...
                                $query = $db->prepare('INSERT INTO `comment` (`nickname`, `message`, `note`, `created_at`, `movie_id1` ) VALUES (:nickname, :message, :note, NOW(), :movie_id)');
                                //on lie les parametres a la requete préparée
                                
                                $query->bindValue(':nickname', $nickname);
                                $query->bindValue(':message', $message);
                                $query->bindValue(':note', $note, PDO::PARAM_INT);
                                $query->bindValue(':movie_id', $movie['id'], PDO::PARAM_INT);

                                $query->execute();

                                //on redirige pour éviter que l'utilisateur ne renvoie le formulaire
                                //header('Location: movie_single.php?id='.$movie['id']);
                                echo '<meta http-equiv="refresh" content="0; URL=\'movie_single.php?id='.$movie['id'].'\'">';

                            }else{?>
                                
                                <div class="container alert alert-danger">
                                    <?php foreach($errors as $error){ ?>
                                        <p class="text-danger m-0"> <?= $error ?></p>
                                    <?php } ?>
                                </div>


                          <?php  }
                        }
                    ?>

                    <form method="POST">
                        <label for="nickname">Pseudo</label>
                        <input type="text" name="nickname" id="nickname" class="form-control"> <br>

                        <label for="message">message</label>
                        <textarea  name="message" id="message" class="form-control" rows="3"></textarea> <br>

                        <label for="note">note</label>
                        <select name="note" id="note" class="form-control">
                            <?php for($i = 0; $i <= 5; $i++){ ?>
                                <option value="<?= $i; ?>"><?= $i; ?>/5</option>
                              <?php }?>
                        </select>
                        <br>
                        <button class="btn btn-danger btn-block">Envoyer</button>
                    </form>
                  
                </div>
            </div>
        </div >
    </div>
</div>


<?php require '../partials/footer.php'; ?>
