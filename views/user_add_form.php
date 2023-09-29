<?php include_once __ROOT__ . "/views/header.php"; ?>

<div class="inscription-form">
    <h1 class="Sous_titre">Inscription - SportTrack</h1>

    <?php if (isset($data['error'])) { ?>
        <section class="error">
            <h3>
                <?php echo $data['error']; ?>
            </h3>
        </section>
    <?php } ?>

    <form action="" method="post">
        <p>Nom :</p>
        <input type="text" name="lastname" required>
        <p>Prenom :</p>
        <input type="text" name="firstname">
        <p>Date de naissance</p>
        <input type="date" name="dateOfBirth" required>
        <p>Sexe</p>
        <div class="radio_button">
            <input type="radio" name="gender" value="M">M
            <input type="radio" name="gender" value="F">F
            <input type="radio" name="gender" value="U">NB
        </div>
        <p>Taille</p>
        <input type="number" name="size" required>
        <p>Poid</p>
        <input type="number" name="weight" required>
        <p>Adresse Email</p>
        <input type="email" name="email" required>
        <p>Votre Mot de passe :</p>
        <input type="password" name="password" required>
        <br>
        <input type="submit" class="envoyer" value="Envoyer">
    </form>

</div>

<?php include_once __ROOT__ . "/views/footer.php"; ?>
