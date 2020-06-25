<?php ob_start(); ?>

<div class="row">
    <div class="col-md-4 offset-md-8">
        <form method="get">
            <div class="form-group has-btn">
                <input type="search" id="search" name="title" value="<?= isset($_GET['title'])?$_GET['title']:null; ?>" class="form-control"
                       placeholder="Rechercher un film ou une série">

                <button type="submit" class="btn btn-block bg-red">Valider</button>
            </div>
        </form>
    </div>
</div>

<div class="media-list">
    <?php
    foreach( $medias as $media ):
    ?>
        <a class="item" href="index.php?media=<?= $media->getId(); ?>">
            <div class="video">
                <div>
                    <iframe frameborder="0"
                            src="<?= $media->getTrailerUrl(); ?>" ></iframe>
                </div>
            </div>
            <div class="title"><?= $media->getTitle(); ?></div>
        </a>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>
