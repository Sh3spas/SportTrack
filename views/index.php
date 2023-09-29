<?php include_once __ROOT__ . "/views/header.php"; ?>

<div class="titleBox">
    <h1 class="sport">SportTrack</h1>
    <h1 class="titre">L'application numéro 1 pour les sportifs !</h1>
    <?php if (isset($_SESSION['fullname'])) : ?>    
        <h3 class="subtitle"> Bonjour <?= $_SESSION['fullname'] ?> !<h1>

    <?php else : ?>
        <p class="text">Nous sommes partenaire ultime pour atteindre vos objectifs sportifs.
        Que vous soyez un athlète professionnel ou un amateur passionné.
        Rejoignez notre nous découvrez la différence avec Sportrack, votre allié vers l'excellence sportive.
        </p>
    <?php endif; ?>

</div>
<div class="centerButton">
        <?php if (isset($_SESSION['fullname'])) : ?>
            <a class="but" href="/activity_add">Ajouter une activité</a>
            <a class="but" href="/activity_list">Voir mes activités</a>
        <?php else : ?>
            <a class="but" href="/user_add">Nous Rejoindre</a>
            <a class="but" href="/user_connect">Se connecter</a>
        <?php endif; ?>
</div>
<?php include_once __ROOT__ . "/views/footer.php"; ?>