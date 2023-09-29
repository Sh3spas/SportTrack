<?php include_once __ROOT__ . "/views/header.php"; ?>

<div class="inscription-form">
    <h1 class="Sous_titre">Modifier Son Compte</h1>

    <?php if (isset($data['error'])) { ?>
        <section class="error">
            <h3>
                <?php echo $data['error']; ?>
            </h3>
        </section>
    <?php } ?>

    <?php if (isset($data['message'])) { ?>
        <section class="message">
            <h3>
                <?php echo $data['message']; ?>
            </h3>
        </section>
    <?php } ?>

    <form action="" method="post">
        <p>Prénom : </p>
        <input type="text" name="firstname" value="<?php echo $data["firstName"]?>" required>
        <p>nom :</p>
        <input type="text" name="lastname" value="<?php echo $data["lastName"]?>" required>
        <p>Date de naissance</p>
        <input type="date" name="dateOfBirth" value="<?php echo $data["dateOfBirth"]?>" required>
        <p>Sexe</p>
        <div class="radio_button">
            <input type="radio" name="gender" <?php if ($data["gender"] === "M") echo "checked"; ?> value="M">M
            <input type="radio" name="gender" <?php if ($data["gender"] === "F") echo "checked"; ?> value="F">F
            <input type="radio" name="gender" <?php if ($data["gender"] === "U") echo "checked"; ?> value="U">NB
        </div>
        <p>Taille</p>
            <input type="number" name="height" value="<?php echo $data["height"]?>" required>
        <p>Poid</p>
        <input type="number" name="weight" value="<?php echo $data["weight"]?>" required>
        <p>Votre Mot de passe :</p>
        <input type="text" name="password" value="<?php echo $data["password"]?>" required>
        <br>
        <input type="submit" class="envoyer" value="Modifier">
    </form>
</div>


<?php include_once __ROOT__ . "/views/footer.php"; ?>
