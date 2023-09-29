<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/index.css">

    <title>Accueil - SportTrack</title>
</head>
<body>
    <header>
        <nav class="">
            <ul class="navbar">
                <a href="/"><img class="logo" src="../static/img/logo.png" alt="logo"></a>
                <li class="btn"><a href="/">Accueil</a></li>
                <?php if (isset($_SESSION['fullname'])) { ?>
                    <li class="btn"><a href="/activity_list">Activités</a></li>
                    <li class="btn"><a href="/update">Mon Compte</a></li>
                    <li class="btn"><a href="/user_disconnect">Se déconnecter</a></li>
                <?php } else { ?>
                    <li class="btn"><a href="/user_add">S'inscrire</a></li>
                    <li class="btn"><a href="/user_connect">Se connecter</a></li>
                    <li class="btn"><a href="/about_us">À propos</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <div id="content">
