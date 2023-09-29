<?php include_once __ROOT__ . "/views/header.php"; ?>

<div class="formulaire">
    <h1 class="Sous_titre">Connection - SportTrack</h1>

    <?php if (isset($data['error'])) { ?>
        <section class="error">
            <h3>
                <?php echo $data['error']; ?>
            </h3>
        </section>
    <?php } ?>


    <form action="" method="post">
        <p>Email :</p>
        <input type="email" name="email" required>
        <p>Mot de passe :</p>
        <input type="password" name="password" required><br>
        <input type="submit" class="envoyer" value="Se Connecter">
    </form>

</div>

<?php include_once __ROOT__ . "/views/footer.php"; ?>
