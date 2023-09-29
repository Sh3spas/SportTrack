<?php include_once __ROOT__ . "/views/header.php"; ?>

<div class="activite">
    <div class="centerButton">
        <h1 class="titre">Vos Activités : </h1>
    </div>
    <div class="grid">
            <h3 class="grid-item">Nom</h3>
            <h3 class="grid-item">Date</h3>
            <h3 class="grid-item">Heure départ</h3>
            <h3 class="grid-item">Durée</h3>
            <h3 class="grid-item">Distance</h3>
            <h3 class="grid-item">Frequence Min</h3>
            <h3 class="grid-item">Frequence Max</h3>
            <h3 class="grid-item">Frequence Avg</h3>
    </div>
    <?php foreach ($data as $activity): ?>
    <div class="grid">
            <h4 class="grid-item"><?= $activity['name']?></h4>
            <h4 class="grid-item"><?= $activity['date']?></h4>
            <h4 class="grid-item"><?= $activity['startTime']?></h4>
            <h4 class="grid-item"><?= $activity['duration']?></h4>
            <h4 class="grid-item"><?= round($activity['distance'],2)?> km</h4>
            <h4 class="grid-item"><?= $activity['minHeartRate']?></h4>
            <h4 class="grid-item"><?= $activity['maxHeartRate']?></h4>
            <h4 class="grid-item"><?= $activity['avgHeartRate']?></h4>
    </div>
    <?php endforeach; ?>
    <div class="centerButton">
        <button class="but"><a href="/activity_add">Ajouter une activité</a></button>
    </div>
</div>
