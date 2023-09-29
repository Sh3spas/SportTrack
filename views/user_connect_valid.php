<?php include_once __ROOT__ . "/views/header.php"; ?>

<div class="titleBox">
    <h1 class="sport">SportTrack</h1>
    <h1 class="titre">L'application numéro 1 pour les sportifs !</h1>
    <h3 class="subtitle"> Bonjour <?= $_SESSION['fullname'] ?> !<h1>
</div>
<div class="centerButton">
        <a class="but" href="/activity_add">Ajouter une activité</a>
        <a class="but" href="/activity_list">Voir mes Activités</a>

</div>
<?php include_once __ROOT__ . "/views/footer.php"; ?>
