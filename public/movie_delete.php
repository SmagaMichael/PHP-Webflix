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

if(!isAdmin()){
    display404();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    //|4 * on doit vérifier si l'id est présent ou non (404)
    display404();
}

//Faille CSRF

$query = $db->prepare('DELETE FROM movie WHERE id = :id');
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

header('Location: movie_list.php');

?>

<?php require '../partials/footer.php'; ?>