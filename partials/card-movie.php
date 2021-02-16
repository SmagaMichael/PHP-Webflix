


    <div class="card">
        <img src="assets/uploads/<?= $movie['cover']; ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= $movie['title']?></h5>
            <p class="card-text">Date de sortie : <?= substr($movie['released_at'],0,4); ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?= $movie['description']?></li>
            <li class="list-group-item">
                <a href="movie_single.php?id=<?= $movie['id']; ?>" 
            class="card-link btn btn-danger btn-block">Voir film</a>
        </li>


        <?php if(isAdmin()){?>
            <li class="list-group-item"><a class="btn btn-secondary btn-block" href="movie_update.php?id=<?= $movie['id']; ?>">Modifier le film</a></li>


            <li class="list-group-item">
                <a class="btn btn-secondary btn-block" 
                    onclick="/* return confirm('Voulez-vous supprimer ce film ?')*/" 
                    href="movie_delete.php?id=<?= $movie['id']; ?>"
                    data-toggle="modal" 
                    data-target="#deleteModal<?= $movie['id']; ?>">Supprimer le film</a>  
            </li>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal<?= $movie['id']; ?>" tabindex="-1" >
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Supprimer <?= $movie['title']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Etes vous sûr de vouloir supprimer le film
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                        <a class="btn btn-danger"  href="movie_delete.php?id=<?= $movie['id']; ?>">Oui</a>
                    </div>
                    </div>
                </div>
                </div>


        <?php }?>
        </ul>

        <div class="card-body">
            <a href="#" class="card-link">★★★☆☆</a>
        </div>
    </div>

   